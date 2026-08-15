<?php
// app/Models/Insemination.php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Insemination extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'cow_id', 'date', 'bull_number', 'successful', 'expected_dob'];
    protected $casts = ['date' => 'date', 'expected_dob' => 'date'];

    public function cow()
    {
        return $this->belongsTo(Cattle::class);
    }
}