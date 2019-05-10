<?php

namespace App\Models;

use App\Models\Traits\DateFormattingTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Users extends Model
{
    use DateFormattingTrait;

    protected $table = 'users';

    protected $fillable = [
        'user_id',
        'user_name',
        'password',
        'created_at'
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}