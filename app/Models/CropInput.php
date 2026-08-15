<?php
// app/Models/CropInput.php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class CropInput extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'crop_field_id', 'date', 'type', 'brand_name', 'quantity', 'unit'];
    protected $casts = ['date' => 'date'];

    public function field() { return $this->belongsTo(CropField::class, 'crop_field_id'); }
}