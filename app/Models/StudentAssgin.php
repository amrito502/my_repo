<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Section;
class StudentAssgin extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'user_id',
        'section_id',
        'student_class_id',
        'shift',
        'status',
    ];

    public function students(){
        return $this->belongsTo(Student::Class ,'user_id','user_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }
    public function studentClass(){
        return $this->belongsTo(StudentClass::Class ,'student_class_id','id');
    }
    public function section(){
        return $this->belongsTo(Section::Class ,'section_id','id');
    }
    public function shift(){
        return $this->belongsTo(Section::Class ,'shift','id');
    }
    public function teachers(){
        return $this->belongsTo(Instructor::Class ,'user_id','user_id');
    }
    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });
    }
}
