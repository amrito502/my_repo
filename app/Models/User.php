<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function is_admin()
    {
        if ($this->role == 1) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */

    public function is_instructor()
    {
        if ($this->role == 2) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */

    public function is_student()
    {
        if ($this->role == 3) {
            return true;
        }
        return false;
    }


    public function instructor()
    {
        return $this->hasOne(Instructor::class,'user_id','id');
    }

    public function assign()
    {
        return $this->hasOne(StudentAssgin::class, 'user_id','id')->with('studentClass','section');
    }

    public function student()
    {
        return $this->hasOne(Student::class,'user_id','id');
    }



    public function getImagePathAttribute()
    {
        if ($this->image)
        {
            return $this->image;
        } else {
            return 'uploads/default/instructor-default.png';
        }
    }
}
