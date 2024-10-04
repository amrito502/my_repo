<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class StudentAttendance extends Model
{
    use HasFactory;

    public function students(){
        return $this->belongsTo(Student::Class ,'student_id','user_id');
    }
    public function teachers(){
        return $this->belongsTo(Instructor::Class ,'teacher_id','user_id');
    }
    public function studentClass(){
        return $this->belongsTo(StudentClass::Class ,'class_id','id')->with('sections');
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });
    }
}
