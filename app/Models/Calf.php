<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calf extends Model
{
    protected $fillable = ['cow_id', 'name', 'dob', 'weight_kg', 'breed', 'gender'];

    public function cattle()
    {
        return $this->belongsTo(Cattle::class, 'cow_id');
    }
}
