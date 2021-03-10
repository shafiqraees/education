<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class ClassRoom extends Model
{
    use Notifiable,HasFactory, SoftDeletes;
    protected $guarded = [];
}
