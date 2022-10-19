<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;
    protected $fillable = ['namePicture', 'urlPicture', 'childs_id'];

    public function childs()
    {
        return $this->hasMany('App\Childs');
    }
}
