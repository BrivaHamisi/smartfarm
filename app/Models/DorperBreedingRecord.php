<?php
// app/Models/DorperBreedingRecord.php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class DorperBreedingRecord extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id', 'ewe_tag', 'ram_tag', 'mating_date',
        'expected_lambing_date', 'lambing_date', 'lambs_born', 'remarks', 'reminder_sent'
    ];
    protected $casts = [
        'mating_date' => 'date',
        'expected_lambing_date' => 'date',
        'lambing_date' => 'date',
    ];
}
