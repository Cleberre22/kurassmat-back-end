<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = ['nameFile', 'urlFile', 'type_files_id', 'childs_id', 'users_id'];

    public function users()
    {
        return $this->hasMany('App\Users');
    }

    public function children()
    {
        return $this->hasMany('App\Children');
    }

    public function typeFiles()
    {
        return $this->hasMany('App\TypeFiles');
    }
}
