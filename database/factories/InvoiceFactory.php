<?php

namespace Database\Factories;

use App\Models\Finances;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $owner = User::query()->where('role', User::ROLE_OWNER)->inRandomOrder()->first() ?? User::factory()->owner()->create();
        $date = fake()->dateTimeBetween('-6 months', 'now');

        return [
            'user_id' => $owner->id,
            'invoice_number' => InvoiceServiceNumber::next($date->format('Y')),
            'customer_name' => fake()->name(),
            'date' => $date,
            'due_date' => (clone $date)->modify('+14 days'),
            'amount' => fake()->randomFloat(2, 500, 250000),
            'status' => fake()->randomElement([Invoice::STATUS_DRAFT, Invoice::STATUS_SENT, Invoice::STATUS_PAID]),
            'notes' => fake()->sentence(),
            'created_by' => $owner->id,
        ];
    }

    public function forOwner(User $owner): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $owner->id,
            'created_by' => $owner->id,
        ]);
    }

    public function fromFinance(Finances $finance): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $finance->user_id,
            'finance_id' => $finance->id,
            'amount' => $finance->amount,
            'date' => $finance->date,
            'notes' => $finance->description ?: $finance->source,
            'invoice_number' => InvoiceServiceNumber::next($finance->date?->format('Y') ?? now()->format('Y')),
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => ['status' => Invoice::STATUS_PAID]);
    }
}

class InvoiceServiceNumber
{
    public static function next(string $year): string
    {
        $last = Invoice::query()
            ->where('invoice_number', 'like', 'INV-'.$year.'-%')
            ->orderByRaw('LENGTH(invoice_number) DESC, invoice_number DESC')
            ->value('invoice_number');

        $sequence = $last ? (int) substr($last, strrpos($last, '-') + 1) + 1 : 1;

        return 'INV-'.$year.'-'.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }
}
