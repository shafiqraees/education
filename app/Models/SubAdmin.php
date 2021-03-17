<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class SubAdmin extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guarded = [];
    protected $guard = 'subadmin';
    public function rooms() {
        return $this->hasManyThrough(ClassRoom::class,Teacher::class);
    }

    public function students() {
        return $this->hasManyThrough(User::class,Teacher::class)->whereNull('users.deleted_at');
    }
}
