<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Exam extends Model
{
    use HasFactory;




   public function subjects(){
    return $this->belongsTo(Subject::class,'subjects_id','id');
   }

   public function teacher(){
    return $this->belongsTo(Instructor::class,'teacher_id','user_id');
   }

   public function exam_mark(){
    return $this->hasMany(ExamMark::class,'exam_id','id')->with('student');
   }



    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });
    }

    
}
