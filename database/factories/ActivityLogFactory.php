<?php

namespace Database\Factories;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    protected $model = ActivityLog::class;

    public function definition(): array
    {
        $owner = User::query()->where('role', User::ROLE_OWNER)->inRandomOrder()->first() ?? User::factory()->owner()->create();

        return [
            'user_id' => $owner->id,
            'farm_id' => $owner->id,
            'action' => ActivityLog::ACTION_LOGIN,
            'description' => fake()->sentence(),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }

    public function forAction(string $action): static
    {
        return $this->state(fn (array $attributes) => ['action' => $action]);
    }

    public function onFarm(?User $owner): static
    {
        return $this->state(fn (array $attributes) => [
            'farm_id' => $owner?->id,
            'user_id' => $owner?->id,
        ]);
    }

    public function at(string $date): static
    {
        return $this->state(fn (array $attributes) => ['created_at' => $date]);
    }
}
