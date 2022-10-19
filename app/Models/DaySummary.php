<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaySummary extends Model
{
    use HasFactory;
    protected $fillable = ['contentDaySummary', 'childs_id', 'users_id'];

    public function childs()
    {
        return $this->hasMany('App\Childs');
    }
}
