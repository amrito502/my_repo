<?php

// app/Models/SmsHistory.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'to',
        'student_id',
        'student_name',
        'class_name',
        'exam_id',
        'message',
        'status_code',
        'response'
    ];
}

