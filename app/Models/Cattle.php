<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cattle extends Model
{
    protected $fillable = ['name', 'age', 'weight_kg', 'breed', 'gender'];

    public function milkProductions() {
        return $this->hasMany(MilkProduction::class);
    }

    public function inseminations() {
        return $this->hasMany(Insemination::class);
    }

    public function calves() {
        return $this->hasMany(Calf::class);
    }

    public function checkups() {
        return $this->hasMany(Checkup::class);
    }
}
