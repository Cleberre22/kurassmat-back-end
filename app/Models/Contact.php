<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = ['firstnameContact', 'lastnameContact', 'emailContact', 'message', 'object', 'users_id'];

    public function users()
    {
        return $this->hasMany('App\Users');
    }
}
