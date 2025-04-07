<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    protected $fillable = ['cow_id', 'date', 'type', 'is_completed'];
}
