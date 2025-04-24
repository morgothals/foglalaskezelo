<section id="staff" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-10">Munkatársak</h2>
        <div class="flex flex-wrap justify-center gap-6">
            @foreach($hairdressers as $hairdresser)
            <div class="bg-white rounded-lg shadow-lg p-4 w-[200px] text-center">
                <img src="{{ asset($hairdresser->profile_image ?? 'images/default-avatar.png') }}" alt="{{ $hairdresser->name }}" class="w-32 h-32 object-cover rounded-full mx-auto mb-4">
                <h3 class="text-lg font-semibold">{{ $hairdresser->name }}</h3>
                <div class="flex justify-center gap-1 my-2">
                    @for($i = 0; $i < round($hairdresser->ratings->avg('stars')); $i++)
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09L5.804 12 1 7.91l6.058-.88L10 2l2.942 5.03L19 7.91 14.196 12l1.682 6.09z" />
                        </svg>
                        @endfor
                </div>
                <a href="/foglalasok" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Foglalás</a>
            </div>
            @endforeach
        </div>
    </div>
</section>
