<?php
// app/Models/RabbitBreedingRecord.php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class RabbitBreedingRecord extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id', 'doe_id', 'buck_id', 'mating_date',
        'expected_kindling_date', 'litter_size', 'reminder_sent'
    ];
    protected $casts = [
        'mating_date' => 'date',
        'expected_kindling_date' => 'date',
    ];
}