<x-mail::message>
# Foglalás visszaigazolás

Kedves {{ $booking['clientName'] }},

Köszönjük, hogy nálunk foglaltál időpontot! A foglalásod részletei:

- **Dátum:** {{ $booking['date'] }}
- **Időpont:** {{ $booking['time'] }}
- **Szolgáltatás:** {{ $booking['serviceName'] }}
- **Fodrász:** {{ $booking['hairdresserName'] }}
- **Megjegyzés:** {{ $booking['notes'] ?? '-' }}

<x-mail::button :url="route('home')">
Vissza a honlapra
</x-mail::button>

Köszönettel,<br>
{{ config('app.name') }} csapata
</x-mail::message>
