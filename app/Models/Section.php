<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\StudentClass;
class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'student_class_id',
        'name',
        'status',
    ];

    public function studentClassData (){
      return  $this->belongsTo(StudentClass::class,'student_classe_id','id');
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });
    }
}
