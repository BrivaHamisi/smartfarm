<?php
// app/Models/CropField.php

namespace App\Models;

use App\Models\CropHarvest;
use App\Models\CropInput;
use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class CropField extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'field_name', 'crop_planted', 'acreage', 'planting_date'];
    protected $casts = ['planting_date' => 'date'];

    public function inputs() { return $this->hasMany(CropInput::class); }
    public function harvests() { return $this->hasMany(CropHarvest::class); }
}