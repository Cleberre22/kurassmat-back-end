<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;
    protected $fillable = ['firstnameChild', 'lastnameChild', 'birthDate', 'imageChild'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function pictures()
    {
        return $this->belongsToMany('App\Pictures');
    }
}
