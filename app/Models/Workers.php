<?php
// app/Models/Workers.php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Workers extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'name', 'salary', 'email', 'password', 'employment_date', 'phone', 'position'];
    protected $hidden = ['password'];
    protected $casts = ['employment_date' => 'date'];
}