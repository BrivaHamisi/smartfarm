<?php
// app/Models/Calf.php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Calf extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'cow_id', 'name', 'dob', 'weight_kg', 'breed', 'gender'];
    protected $casts = ['dob' => 'date'];

    public function cattle() { return $this->belongsTo(Cattle::class, 'cow_id'); }
}