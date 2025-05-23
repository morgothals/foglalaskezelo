<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="utf-8">
    <title>Foglalás visszaigazolás</title>
</head>

<body>
    <h1>Foglalás visszaigazolás</h1>

    <p>Kedves {{ $booking['clientName'] }},</p>

    <p>Köszönjük, hogy nálunk foglaltál időpontot! A foglalásod részletei:</p>
    <ul>
        <li><strong>Dátum:</strong> {{ $booking['date'] }}</li>
        <li><strong>Időpont:</strong> {{ $booking['time'] }}</li>
        <li><strong>Szolgáltatás:</strong> {{ $booking['serviceName'] }}</li>
        <li><strong>Fodrász:</strong> {{ $booking['hairdresserName'] }}</li>
        <li><strong>Megjegyzés:</strong> {{ $booking['notes'] ?? '-' }}</li>
    </ul>

    <p>
        <a href="{{ route('home') }}">Vissza a honlapra</a>
    </p>

    <p>Köszönettel,<br>{{ config('app.name') }} csapata</p>
</body>

</html>
