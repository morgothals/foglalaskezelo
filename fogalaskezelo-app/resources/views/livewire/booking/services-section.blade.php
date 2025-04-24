<section id="services" class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-3xl font-semibold text-center mb-10">Szolgáltatások</h2>

        <ul class="space-y-4">
            @foreach($services as $service)
            <li class="bg-white p-4 rounded shadow flex justify-between items-center hover:shadow-md transition">
                <div>
                    <h3 class="text-lg font-bold">{{ $service['name'] }}</h3>
                </div>
                <div class="text-right">
                    <span class="text-gray-700 font-semibold">{{ number_format($service['min_price'], 0, ',', ' ') }}
                        Ft-tól</span>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</section>