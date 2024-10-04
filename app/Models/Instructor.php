<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Instructor extends Model
{
    use HasFactory;

    protected $table = 'instructors';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'professional_title',
        'phone_number',
        'postal_code',
        'address',
        'gender',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFullNameAttribute($value)
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 1);
    }

    public function scopeBlocked($query)
    {
        return $query->where('status', 2);
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });
    }


}
