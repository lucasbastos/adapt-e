<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    protected $fillable = ['name', 'description', 'course_id'];

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    protected $hidden = [
        'deleted_at',
    ];
    
    protected $dates = ['deleted_at'];
    
    use HasFactory;
    use softDeletes;
}
