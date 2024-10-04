<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = [
        'uuid',
        'user_id',
        'student_number',
        'instructor_id',
        'first_name',
        'last_name',
        'address',
        'phone_number',
        'gurdian_phone_number',
        'about_me',
        'gender',
    ];


    public static function generateUniqueId($gender, $branch, $class)
    {
        $genderAbbreviation = strtoupper(substr($gender, 0, 1));
        $branchAbbreviation = strtoupper(substr($branch, 0, 2));
        $classAbbreviation = strtoupper(substr($class, 6, 2));
        $uniqueId = $genderAbbreviation . '-' . $branchAbbreviation . '-' . $classAbbreviation . '-' . uniqid();
        return $uniqueId;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assign()
    {
        return $this->belongsTo(StudentAssgin::class, 'user_id','user_id')->with('studentClass','section');
    }

    public function class()
    {
        return $this->belongsTo(StudentAssgin::class, 'user_id','user_id')->with('studentClass','section'); ;
    }

    public function attendance()
    {
        return $this->hasMany(StudentAttendance::class);
    }


    public function getNameAttribute()
    {
        return $this->first_name .' '. $this->last_name;
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 1);
    }

    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    public function assignments()
    {
        return $this->hasMany(StudentAssgin::class, 'user_id');
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });
    }

}
