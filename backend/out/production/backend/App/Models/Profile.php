<?php

// app/Models/Profile.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'location',
        'profile_image_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}