<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;


    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function classes()
    {
        return $this->hasMany(StudentClass::class);
    }

}


