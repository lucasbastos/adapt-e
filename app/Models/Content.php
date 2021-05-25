<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    protected $fillable = ['type', 'module_id','views'];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
    
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'deleted_at',
    ];
    
    use HasFactory;
    use softDeletes;
}
