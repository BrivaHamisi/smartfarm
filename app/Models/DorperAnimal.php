<?php
// app/Models/DorperAnimal.php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class DorperAnimal extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'tag_number', 'date_of_birth', 'breed_lineage', 'gender', 'weight_kg', 'notes'];
    protected $casts = ['date_of_birth' => 'date'];
}