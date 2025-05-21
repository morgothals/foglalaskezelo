<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hairdresser;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Appointment;
use App\Models\Rating;
use App\Models\AvailabilitySlot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Teszt felhasználó
        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Fodrászok
        $hairdresser1 = Hairdresser::create([
            'name'          => 'Kovács László',
            'profile_image' => 'images/hairdressers/Zbisko_Adam.jpeg'
        ]);
        $hairdresser2 = Hairdresser::create([
            'name'          => 'Szabó Anna',
            'profile_image' => 'images/hairdressers/Simon_Bertold.jpeg'
        ]);
        $hairdresser3 = Hairdresser::create([
            'name'          => 'Nagy Péter',
            'profile_image' => 'images/hairdressers/Bartfai_Zsombor.jpeg'
        ]);

        // Szolgáltatások
        $service1 = Service::firstOrCreate(['name' => 'Hajvágás']);
        $service2 = Service::firstOrCreate(['name' => 'Hajfestés']);
        $service3 = Service::firstOrCreate(['name' => 'Balayage']);

        // Fodrász–szolgáltatás pivot + árak
        $hairdresser1->services()->attach($service1->service_id, ['price' => 5400]);
        $hairdresser1->services()->attach($service2->service_id, ['price' => 8200]);

        $hairdresser2->services()->attach($service1->service_id, ['price' => 5000]);
        $hairdresser2->services()->attach($service3->service_id, ['price' => 10500]);

        $hairdresser3->services()->attach($service2->service_id, ['price' => 7900]);
        $hairdresser3->services()->attach($service3->service_id, ['price' => 12000]);

        // Ügyfelek
        $customer1 = Customer::create([
            'name'         => 'Tóth Ádám',
            'email'        => 'adam.toth@example.com',
            'phone_number' => '06201234567',
        ]);
        $customer2 = Customer::create([
            'name'         => 'Kiss Réka',
            'email'        => 'reka.kiss@example.com',
            'phone_number' => '06301234567',
        ]);
        $customer3 = Customer::create([
            'name'         => 'Farkas Bence',
            'email'        => 'bence.farkas@example.com',
            'phone_number' => '06701234567',
        ]);

        // Időpontfoglalások
        Appointment::create([
            'customer_id'      => $customer1->customer_id,
            'hairdresser_id'   => $hairdresser1->hairdresser_id,
            'service_id'       => $service1->service_id,
            'appointment_time' => '2025-04-23 10:00:00',
        ]);
        Appointment::create([
            'customer_id'      => $customer2->customer_id,
            'hairdresser_id'   => $hairdresser2->hairdresser_id,
            'service_id'       => $service3->service_id,
            'appointment_time' => '2025-04-24 14:30:00',
        ]);
        Appointment::create([
            'customer_id'      => $customer3->customer_id,
            'hairdresser_id'   => $hairdresser1->hairdresser_id,
            'service_id'       => $service2->service_id,
            'appointment_time' => '2025-04-25 09:00:00',
        ]);

        // Értékelések
        Rating::create([
            'hairdresser_id' => $hairdresser1->hairdresser_id,
            'stars'          => 5,
            'review'         => 'Nagyon profi munka, teljesen elégedett vagyok!',
        ]);
        Rating::create([
            'hairdresser_id' => $hairdresser2->hairdresser_id,
            'stars'          => 4,
            'review'         => 'Jó volt, de kicsit lassú volt a várakozás.',
        ]);
        Rating::create([
            'hairdresser_id' => $hairdresser3->hairdresser_id,
            'stars'          => 5,
            'review'         => 'Szuper volt, tökéletes frizura!',
        ]);

        // Teszt fodrász user + modell
        $u = User::factory()->create([
            'email'    => 'fodrasz@example.com',
            'password' => bcrypt('secret123'),
            'role'     => 'hairdresser',
        ]);
        $testHairdresser = Hairdresser::create([
            'user_id'       => $u->id,
            'name'          => 'Teszt Fodrász',
            'profile_image' => 'images/hairdressers/test.jpg',
        ]);

        // Szolgáltatások a teszt fodrászhoz
        $testHairdresser->services()->attach($service1->service_id, ['price' => 6000]);
        $testHairdresser->services()->attach($service2->service_id, ['price' => 8000]);
        $testHairdresser->services()->attach($service3->service_id, ['price' => 10000]);

        // 🆕 Elérhetőségi időpontok generálása minden fodrászhoz
        $hairdressers = Hairdresser::all();

        foreach ($hairdressers as $hairdresser) {
            for ($i = 0; $i < 10; $i++) {
                AvailabilitySlot::create([
                    'hairdresser_id' => $hairdresser->hairdresser_id,
                    'start_time'     => Carbon::now()->addDays($i)->setTime(9, 0),
                    'end_time'       => Carbon::now()->addDays($i)->setTime(9, 30),
                ]);
            }
        }
    }
}
