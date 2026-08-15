<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'cow_id', 'date', 'type', 'is_completed'];

    protected $casts = [
        'date' => 'date',
        'is_completed' => 'boolean',
    ];

    public function cow()
    {
        return $this->belongsTo(Cattle::class, 'cow_id');
    }
}
