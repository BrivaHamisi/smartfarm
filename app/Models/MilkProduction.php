<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MilkProduction extends Model
{
    protected $fillable = ['cow_id', 'morning', 'afternoon', 'evening', 'date'];

    public function cow() {
        return $this->belongsTo(Cattle::class, 'cow_id');
    }
}
