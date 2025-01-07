<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    use HasFactory;
    protected $model = \App\Models\Attendance::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attendee_id' => $this->faker->unique()->numberBetween(1, 1000),
            'is_present' => $this->faker->boolean(),
        ];
    }

    public function present(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_present' => true,
            ];
        });
    }
}
