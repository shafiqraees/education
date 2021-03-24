<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuiz extends Model
{
    use HasFactory;
     protected $guarded = [];

    function launchQuiz() {
        return $this->belongsTo(LaunchQuiz::class);
    }
    public function questionPaper(){
        return $this->belongsTo(QuestionPaper::class);
    }
}
