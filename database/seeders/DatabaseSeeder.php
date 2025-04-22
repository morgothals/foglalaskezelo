<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hairdresser;
use App\Models\Service;
use App\Models\HairdresserService;
use App\Models\Customer;
use App\Models\Appointment;
use App\Models\Rating;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Fodrászok
        $hairdresser1 = Hairdresser::create(['name' => 'Kovács László']);
        $hairdresser2 = Hairdresser::create(['name' => 'Szabó Anna']);
        $hairdresser3 = Hairdresser::create(['name' => 'Nagy Péter']);

        // Szolgáltatások
        $service1 = Service::create(['name' => 'Hajvágás', 'price' => 5000]);
        $service2 = Service::create(['name' => 'Hajfestés', 'price' => 8000]);
        $service3 = Service::create(['name' => 'Balayage', 'price' => 12000]);

        // Kapcsolatok fodrászok és szolgáltatások között
        $hairdresser1->services()->attach([$service1->service_id, $service2->service_id]);
        $hairdresser2->services()->attach([$service1->service_id, $service3->service_id]);
        $hairdresser3->services()->attach([$service2->service_id, $service3->service_id]);

        // Ügyfelek
        $customer1 = Customer::create([
            'name'         => 'Tóth Ádám',
            'email'        => 'adam.toth@example.com',
            'phone_number' => '06201234567'
        ]);

        $customer2 = Customer::create([
            'name'         => 'Kiss Réka',
            'email'        => 'reka.kiss@example.com',
            'phone_number' => '06301234567'
        ]);

        $customer3 = Customer::create([
            'name'         => 'Farkas Bence',
            'email'        => 'bence.farkas@example.com',
            'phone_number' => '06701234567'
        ]);

        // Időpontfoglalások
        Appointment::create([
            'customer_id'      => $customer1->customer_id,
            'hairdresser_id'   => $hairdresser1->hairdresser_id,
            'service_id'       => $service1->service_id,
            'appointment_time' => '2025-04-23 10:00:00',
            'status'           => 'confirmed'
        ]);

        Appointment::create([
            'customer_id'      => $customer2->customer_id,
            'hairdresser_id'   => $hairdresser2->hairdresser_id,
            'service_id'       => $service3->service_id,
            'appointment_time' => '2025-04-24 14:00:00',
            'status'           => 'confirmed'
        ]);

        Appointment::create([
            'customer_id'      => $customer3->customer_id,
            'hairdresser_id'   => $hairdresser3->hairdresser_id,
            'service_id'       => $service2->service_id,
            'appointment_time' => '2025-04-25 12:00:00',
            'status'           => 'confirmed'
        ]);

        // Értékelések
        Rating::create([
            'hairdresser_id' => $hairdresser1->hairdresser_id,
            'stars'          => 5,
            'review'         => 'Nagyon profi vágás!'
        ]);

        Rating::create([
            'hairdresser_id' => $hairdresser2->hairdresser_id,
            'stars'          => 4,
            'review'         => 'Szép színezés, de kicsit sokat kellett várni.'
        ]);

        Rating::create([
            'hairdresser_id' => $hairdresser3->hairdresser_id,
            'stars'          => 5,
            'review'         => 'Imádom az új frizurámat!'
        ]);
    }
}
