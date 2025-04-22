<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Fodrászok listája</h1>

    @foreach($hairdressers as $hairdresser)
        <div class="mb-6 p-4 border rounded-lg shadow">
            <h2 class="text-xl font-semibold">{{ $hairdresser->name }}</h2>

            <h3 class="mt-2 font-semibold">Szolgáltatások:</h3>
            <ul class="list-disc list-inside">
                @foreach($hairdresser->services as $service)
                    <li>{{ $service->name }} - {{ number_format($service->price, 0, '', ' ') }} Ft</li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>

