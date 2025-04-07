<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poultry extends Model
{
    protected $fillable = ['date', 'chicken_count', 'mortalities', 'eggs_produced', 'eggs_sold'];
}
