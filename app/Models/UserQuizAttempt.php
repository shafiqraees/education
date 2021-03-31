<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuizAttempt extends Model
{
    use HasFactory;

    protected $guarded = [];
    function userQuiz() {
        return $this->belongsTo(UserQuiz::class);
    }
    function launchQuiz() {
        return $this->belongsTo(LaunchQuiz::class);
    }
    function user() {
        return $this->belongsTo(User::class);
    }
}
