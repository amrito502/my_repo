<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class ExamMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'mark',
        'max_mark',
    ];

    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }
    public function exam(){
        return $this->belongsTo(Exam::class,'exam_id','id')->with('subjects');
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });
    }
}
