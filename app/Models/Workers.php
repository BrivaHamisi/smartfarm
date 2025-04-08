<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class Workers extends Model
{
    protected $fillable = ['name', 'salary', 'email', 'password', 'employment_date', 'phone', 'position'];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
