<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insemination extends Model
{
    protected $fillable = ['cow_id', 'date', 'bull_number', 'successful', 'expected_dob'];

    public function cow() {
        return $this->belongsTo(Cattle::class);
    }
}
