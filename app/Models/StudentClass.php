<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Section;
class StudentClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'subjects',
        'status',
    ];

    public function sections(){
        return $this->hasOne(Section::class,'student_classe_id','id');
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });
    }
}
