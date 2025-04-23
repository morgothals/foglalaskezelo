<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Hairdresser;
use App\Models\Service;
use App\Models\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id'      => Customer::factory(),
            'hairdresser_id'   => Hairdresser::factory(),
            'service_id'       => Service::factory(),
            'appointment_time' => $this->faker->dateTimeBetween('+1 days', '+1 month'),
            'status'           => $this->faker->randomElement(['confirmed', 'cancelled', 'completed']),
        ];
    }
}
