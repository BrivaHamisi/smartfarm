<?php
// app/Models/Rabbit.php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Rabbit extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'rabbit_id', 'breed', 'gender'];
}