<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnlockSubModule extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = [
        'user_id',
        'sub_module_id',
        'submit_status',       
    ];

}
