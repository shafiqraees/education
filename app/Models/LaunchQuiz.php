<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaunchQuiz extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function className(){
        return $this->belongsTo(ClassRoom::class,'class_room_id');
    }

    public function questionPaper(){
        return $this->belongsTo(QuestionPaper::class);
    }
    public function methodsAndSettings(){
        return $this->hasMany(MethodSetting::class,'launch_quizze_id');
    }
}
