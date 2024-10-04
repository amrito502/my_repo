<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class ExampMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'mark', // Add 'mark' to the fillable array
        // Add other fillable properties here if needed
    ];

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });
    }
}
