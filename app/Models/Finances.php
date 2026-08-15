<?php
// app/Models/Finances.php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Finances extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'type', 'amount', 'category', 'date', 'description', 'source'];
    protected $casts = ['date' => 'date'];
}