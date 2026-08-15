<?php
// app/Models/MilkProduction.php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class MilkProduction extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'cow_id', 'morning', 'afternoon', 'evening', 'date'];
    protected $casts = ['date' => 'date'];

    public function cow()
    {
        return $this->belongsTo(Cattle::class, 'cow_id');
    }

    public function getTotalYieldAttribute(): float
    {
        return $this->morning + $this->afternoon + $this->evening;
    }
}