<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guarded = [];
    protected $guard = 'teacher';

    public function subAdmin() {
        return $this->belongsTo(SubAdmin::class);
    }
}
