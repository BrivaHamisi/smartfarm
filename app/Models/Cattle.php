<?php
// app/Models/Cattle.php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cattle extends Model
{
    use HasFactory, BelongsToUser;

    protected $fillable = ['user_id', 'name', 'age', 'weight_kg', 'breed', 'gender'];

    public function milkProductions()
    {
        return $this->hasMany(MilkProduction::class, 'cow_id');
    }
    public function calves()
    {
        return $this->hasMany(Calf::class, 'cow_id');
    }
}