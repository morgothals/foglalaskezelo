Egy fodrászathoz lenne foglalási honlap és ezt az adatbázisszerkezetet találtam hozzá:
"npm## Barber -appointment booking page



Az alábbiakban egy lépésenként felépített megvalósítási tervet találsz arra, hogyan építsünk be egy `/admin` felületet a fodrászok számára, ahol beállíthatják elérhetőségüket idő­sávokban, valamint hogyan integráljuk ezt a kliensoldali foglalásba. A terv figyelembe veszi a jelenlegi adatbázis­szerkezetet és a summary.txt-ben található modelleket-migrációkat.

---

## 1. Felhasználói szerepkörök és hitelesítés

1. **`users` tábla bővítése**

   * Hozzáadunk egy `role` oszlopot: `enum('customer','hairdresser','admin')`, alapértelmezetten `customer`.
   * Migration parancs:

     ```bash
     php artisan make:migration add_role_to_users_table --table=users
     ```

   * A migration `up()`-ban:

     ```php
     $table->enum('role', ['customer','hairdresser','admin'])
           ->default('customer')
           ->after('remember_token');
     ```

   * A `down()` visszacsinálja az oszlopot.

   Így a későbbiekben a jogosultságokat (`Gate` vagy `Policy`) e `role` mezőre tudjuk építeni .

2. **Fodrász–felhasználó kapcsolat**

   * A `hairdressers` tábla kapjon egy `user_id` FK oszlopot, hogy egy fodrászhoz tartozzon belépési hitelesítés.
   * Migration parancs:

     ```bash
     php artisan make:migration add_user_id_to_hairdressers_table --table=hairdressers
     ```

   * `up()`-ban:

     ```php
     $table->foreignId('user_id')
           ->nullable()
           ->constrained('users')
           ->cascadeOnDelete()
           ->after('profile_image');
     ```

   * `down()`-ban:

     ```php
     $table->dropForeign(['user_id']);
     $table->dropColumn('user_id');
     ```

   * Modellekben:

     ```php
     // app/Models/Hairdresser.php
     public function user()
     {
         return $this->belongsTo(User::class, 'user_id');
     }
     // app/Models/User.php
     public function hairdresser()
     {
         return $this->hasOne(Hairdresser::class, 'user_id');
     }
     ```

3. **Middleware / Gate**

   * `AuthServiceProvider`-ben regisztráljunk egy gate-et:

     ```php
     Gate::define('access-admin', fn(User $u) => $u->role === 'hairdresser');
     ```

   * A `/admin` útvonalcsoport middleware-e legyen `['auth','can:access-admin']`.

---

## 2. Új adatbázis­tábla: elérhetőségi idő­sávok

1. **Migration létrehozása**

   ```bash
   php artisan make:migration create_availability_slots_table
   ```

2. **Táblaszerkezet** (`database/migrations/xxxx_xx_xx_create_availability_slots_table.php`):

   ```php
   Schema::create('availability_slots', function (Blueprint $table) {
       $table->id('slot_id');
       $table->foreignId('hairdresser_id')
             ->constrained('hairdressers','hairdresser_id')
             ->cascadeOnDelete();
       $table->timestamp('start_time');
       $table->timestamp('end_time');
       $table->timestamps();
   });
   ```

   Ez a tábla tárolja az egyes 45 perces vagy tetszőleges hosszúságú idősávokat, amelyeket a fodrász beállít .

3. **Model létrehozása**

   ```bash
   php artisan make:model AvailabilitySlot
   ```

   és az `app/Models/AvailabilitySlot.php`:

   ```php
   namespace App\Models;
   use Illuminate\Database\Eloquent\Model;

   class AvailabilitySlot extends Model
   {
       protected $primaryKey = 'slot_id';
       protected $fillable = ['hairdresser_id','start_time','end_time'];

       public function hairdresser()
       {
           return $this->belongsTo(Hairdresser::class, 'hairdresser_id', 'hairdresser_id');
       }
   }
   ```

   A `Hairdresser` modellben:

   ```php
   public function availabilitySlots()
   {
       return $this->hasMany(AvailabilitySlot::class, 'hairdresser_id', 'hairdresser_id');
   }
   ```

---Kidolgoznád ugynígy a 3-as pontot  úgy ahogy az instrukciókban van (teljes tartalom, hova stb) ?

## 3. Admin felület tervezete (`/admin`)

1. **Route-ok** (`routes/web.php`):

   ```php
   Route::middleware(['auth','can:access-admin'])
        ->prefix('admin')
        ->group(function(){
            Route::get('/', Admin\DashboardController::class)->name('admin.dashboard');
            Route::get('availability', Admin\AvailabilityController::class.'@index')->name('admin.availability.index');
            Route::post('availability', Admin\AvailabilityController::class.'@store')->name('admin.availability.store');
            Route::delete('availability/{slot}', Admin\AvailabilityController::class.'@destroy')->name('admin.availability.destroy');
        });
   ```

2. **Controller vagy Livewire**

   * Javasolt Livewire-komponens (`php artisan make:livewire admin.availability-manager`), ami:

     * `render()`-ben kilistázza a `auth()->user()->hairdresser->availabilitySlots`
     * Formjal fogadja a `date`, `start_time`, `end_time` mezőket
     * A leadott ablak alapján 45 perces intervallumokra bontja a megadott idő­ablakot, és létrehozza a `AvailabilitySlot` rekordokat
     * Törlésnél eltávolítja a kiválasztott sávot

3. **Nézetek**

   * `resources/views/admin/layout.blade.php`: admin­specifikus menü, `@yield('content')`
   * `resources/views/livewire/admin/availability-manager.blade.php`: lista + űrlap.

---

## 4. Foglalási logika a kliensoldalon

1. **Elérhető sávok lekérdezése**
   A foglaló űrlapon a kiválasztott fodrászra:

   ```php
   $slots = AvailabilitySlot::where('hairdresser_id', $hairdresser->hairdresser_id)
                             ->where('start_time','>=', now())
                             ->whereNotExists(fn($q)=> $q->from('appointments','a')
                                 ->whereColumn('a.appointment_time','availability_slots.start_time'))
                             ->get();
   ```

2. **45 perces fix hosszúság**
   Az adminnál generált `end_time` mindig `start_time->addMinutes(45)`, így a kliensnek csak `start_time`-ot kell választania.

3. **Appointment létrehozása**
   A foglaláskor:

   ```php
   Appointment::create([
     'customer_id'      => auth()->id(),
     'hairdresser_id'   => $hairdresser->hairdresser_id,
     'service_id'       => $service->service_id,
     'appointment_time' => $slot->start_time,
   ]);
   ```

---

## 5. Jogosultságkezelés (Policies)

* **`AvailabilitySlotPolicy`**: csak a saját fodrász slotjait kezelheti (view/create/delete).
* **`AppointmentPolicy`**: kliens foglalhat, fodrász csak saját slotban lát el (opcionális).

Regisztrálás az `AuthServiceProvider`-ben:

```php
protected $policies = [
    AvailabilitySlot::class => AvailabilitySlotPolicy::class,
    Appointment::class      => AppointmentPolicy::class,
];
```

---

### Összefoglalva

1. **Felhasználói szerepkörök kiterjesztése** (`users.role`, `hairdressers.user_id`).
2. **Új `availability_slots` tábla** a fodrászi idő­sávoknak.
3. **Admin útvonalak, Livewire komponens** az idő­sávok menedzseléséhez.
4. **Kliens foglaló űrlap**: a szabad sávok lekérése és foglalása 45 percre.
5. **Policies** a jogosultságok szigorú megtartásához.

Ezzel a tervvel moduláris, jól elkülönülő részekre bontva építhetjük be a kívánt admin felületet és időpontkezelést, miközben a meglévő auth rendszert és a summary.txt-ben leírt adatbázist is megtartjuk és kiegészítjük.




References:
Create
<https://www.createsculture.hu/>

Tables:
hairdressers

* hairdresser_id
* name
* service_id  --- rossz mert több szolgáltatás is lehet

ratings

* hairdresser_id
* stars
* review
* timestamp

services

* service_id
* name
* price
* timestamp

customers

* customer_id
* name
* email
* phone_number
* previous_appointments -- ez  így redundáns nem kell
* timestamp

appointments

* timestamp
* customer_id
* hairdresser_id
* service_id
* enum -status

### Normalized tables

**1. Hairdressers:**

```sql
CREATE TABLE hairdressers (
    hairdresser_id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
```

**2. Services:**

```sql
CREATE TABLE services (
    service_id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**3. Hairdresser_Services:**

```sql
CREATE TABLE hairdresser_services (
    hairdresser_id INT,
    service_id INT,
    PRIMARY KEY (hairdresser_id, service_id),
    FOREIGN KEY (hairdresser_id) REFERENCES hairdressers(hairdresser_id),
    FOREIGN KEY (service_id) REFERENCES services(service_id)
);
```

**4. Ratings:**

```sql
CREATE TABLE ratings (
    rating_id INT PRIMARY KEY AUTO_INCREMENT,
    hairdresser_id INT,
    stars INT NOT NULL,
    review TEXT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hairdresser_id) REFERENCES hairdressers(hairdresser_id)
);
```

**5. Customers (Ügyfelek):**

```sql
CREATE TABLE customers (
    customer_id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone_number VARCHAR(20),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**6. Appointments (Foglalások):**

```sql
CREATE TABLE appointments (
    appointment_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    hairdresser_id INT,
    service_id INT,
    appointment_time TIMESTAMP NOT NULL,
    status ENUM('confirmed', 'cancelled', 'completed') DEFAULT 'confirmed',
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id),
    FOREIGN KEY (hairdresser_id) REFERENCES hairdressers(hairdresser_id),
    FOREIGN KEY (service_id) REFERENCES services(service_id)
);
```

## Migration file

### 1. **Generate the migration files:**

You can generate the migration files using Artisan commands for each table:

```bash
php artisan make:migration create_hairdressers_table --create=hairdressers
php artisan make:migration create_services_table --create=services
php artisan make:migration create_hairdresser_services_table --create=hairdresser_services
php artisan make:migration create_ratings_table --create=ratings
php artisan make:migration create_customers_table --create=customers
php artisan make:migration create_appointments_table --create=appointments
```

After running these commands, you'll find the migration files inside the `database/migrations` folder.

### 2. **Writing the migrations:**

Now, let's write the actual migrations for each table.

#### **Migration for `hairdressers` table:**

```php
// database/migrations/xxxx_xx_xx_xxxxxx_create_hairdressers_table.php
public function up()
{
    Schema::create('hairdressers', function (Blueprint $table) {
        $table->id('hairdresser_id');
        $table->string('name');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('hairdressers');
}
```

#### **Migration for `services` table:**

```php
// database/migrations/xxxx_xx_xx_xxxxxx_create_services_table.php
public function up()
{
    Schema::create('services', function (Blueprint $table) {
        $table->id('service_id');
        $table->string('name');
        $table->decimal('price', 10, 2);
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('services');
}
```

#### **Migration for `hairdresser_services` table:**

```php
// database/migrations/xxxx_xx_xx_xxxxxx_create_hairdresser_services_table.php
public function up()
{
    Schema::create('hairdresser_services', function (Blueprint $table) {
        $table->unsignedBigInteger('hairdresser_id');
        $table->unsignedBigInteger('service_id');
        $table->primary(['hairdresser_id', 'service_id']);
        
        $table->foreign('hairdresser_id')->references('hairdresser_id')->on('hairdressers')->onDelete('cascade');
        $table->foreign('service_id')->references('service_id')->on('services')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('hairdresser_services');
}
```

#### **Migration for `ratings` table:**

```php
// database/migrations/xxxx_xx_xx_xxxxxx_create_ratings_table.php
public function up()
{
    Schema::create('ratings', function (Blueprint $table) {
        $table->id('rating_id');
        $table->unsignedBigInteger('hairdresser_id');
        $table->integer('stars');
        $table->text('review')->nullable();
        $table->timestamps();
        
        $table->foreign('hairdresser_id')->references('hairdresser_id')->on('hairdressers')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('ratings');
}
```

#### **Migration for `customers` table:**

```php
// database/migrations/xxxx_xx_xx_xxxxxx_create_customers_table.php
public function up()
{
    Schema::create('customers', function (Blueprint $table) {
        $table->id('customer_id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone_number')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('customers');
}
```

#### **Migration for `appointments` table:**

```php
// database/migrations/xxxx_xx_xx_xxxxxx_create_appointments_table.php
public function up()
{
    Schema::create('appointments', function (Blueprint $table) {
        $table->id('appointment_id');
        $table->unsignedBigInteger('customer_id');
        $table->unsignedBigInteger('hairdresser_id');
        $table->unsignedBigInteger('service_id');
        $table->timestamp('appointment_time');
        $table->enum('status', ['confirmed', 'cancelled', 'completed'])->default('confirmed');
        $table->timestamps();

        $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
        $table->foreign('hairdresser_id')->references('hairdresser_id')->on('hairdressers')->onDelete('cascade');
        $table->foreign('service_id')->references('service_id')->on('services')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('appointments');
}
```

### 3. **Run the migrations:**

Once the migration files are created and written, you can run the migrations using the following command:

```bash
php artisan migrate
```

This will create all the tables (`hairdressers`, `services`, `hairdresser_services`, `ratings`, `customers`, and `appointments`) in your database.

---
"
