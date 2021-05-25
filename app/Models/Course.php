<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Course extends Model
{
    protected $fillable = ['title', 'code', 'description', 'started_at', 'finished_at','active', 'user_id'];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $hidden = [
        'deleted_at',
    ];


    use HasFactory;
    use softDeletes;
}
