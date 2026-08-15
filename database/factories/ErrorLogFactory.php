<?php

namespace Database\Factories;

use App\Models\ErrorLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ErrorLog>
 */
class ErrorLogFactory extends Factory
{
    protected $model = ErrorLog::class;

    public function definition(): array
    {
        $owner = User::query()->where('role', User::ROLE_OWNER)->inRandomOrder()->first() ?? User::factory()->owner()->create();

        return [
            'level' => 'error',
            'type' => fake()->randomElement(['QueryException', 'TypeError', 'RuntimeException']),
            'message' => fake()->sentence(),
            'file' => fake()->filePath(),
            'line' => fake()->numberBetween(1, 500),
            'url' => fake()->url(),
            'method' => 'GET',
            'user_id' => $owner->id,
            'farm_id' => $owner->id,
            'ip_address' => fake()->ipv4(),
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }

    public function onFarm(?User $owner): static
    {
        return $this->state(fn (array $attributes) => [
            'farm_id' => $owner?->id,
            'user_id' => $owner?->id,
        ]);
    }
}
