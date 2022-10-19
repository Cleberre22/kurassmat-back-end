<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonToContact extends Model
{
    use HasFactory;
    protected $fillable = ['firstnamePerson', 'lastnamePerson', 'addressPerson', 'phonePerson'];

    public function children()
    {
        return $this->belongsToMany(Child::class);
    }
}
