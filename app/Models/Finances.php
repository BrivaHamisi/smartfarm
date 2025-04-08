<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finances extends Model
{
    protected $table = 'financials';

    protected $fillable = ['type', 'amount', 'category', 'date'];
}
