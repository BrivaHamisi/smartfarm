<?php
// app/Models/Poultry.php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Poultry extends Model
{
    use BelongsToUser;

    protected $table = 'poultry';

    protected $fillable = ['user_id', 'date', 'chicken_count', 'mortalities', 'eggs_produced', 'eggs_sold'];
    protected $casts = ['date' => 'date'];
}