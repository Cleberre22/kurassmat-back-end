<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeFile extends Model
{
    use HasFactory;
    protected $fillable = ['nameTypeFile'];

    public function files()
    {
        return $this->belongsToMany('App\Files');
    }
}
