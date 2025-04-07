<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workers extends Model
{
    protected $fillable = ['name', 'salary', 'email', 'password', 'employment_date', 'phone', 'position'];
}
