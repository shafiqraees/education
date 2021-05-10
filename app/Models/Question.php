<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function option() {
        return $this->hasMany(QuestionOption::class);
    }

    public function paper() {
        return $this->belongsTo(QuestionPaper::class,'question_paper_id');
    }
}
