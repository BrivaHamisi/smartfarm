<?php
// app/Models/CropHarvest.php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class CropHarvest extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'crop_field_id', 'date', 'crop', 'quantity_harvested', 'unit'];
    protected $casts = ['date' => 'date'];

    public function field() { return $this->belongsTo(CropField::class, 'crop_field_id'); }
}