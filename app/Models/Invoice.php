<?php

namespace App\Models;

use App\Services\InvoiceService;
use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Invoice extends Model
{
    use BelongsToUser;
    use HasFactory;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_SENT = 'sent';

    public const STATUS_PAID = 'paid';

    protected $fillable = [
        'user_id',
        'invoice_number',
        'finance_id',
        'customer_name',
        'date',
        'due_date',
        'amount',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Invoice $invoice) {
            if (empty($invoice->invoice_number)) {
                $invoice->invoice_number = InvoiceService::generateNumber(
                    Carbon::parse($invoice->date ?? today())->year
                );
            }
        });
    }

    public function finance()
    {
        return $this->belongsTo(Finances::class, 'finance_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }
}
