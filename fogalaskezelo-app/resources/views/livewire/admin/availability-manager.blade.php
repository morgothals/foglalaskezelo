<div class="space-y-6">

    <!-- Új elérhetőségi ablak űrlap -->
    <form wire:submit.prevent="store" class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-medium mb-4">Új elérhetőségi ablak</h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700">Dátum</label>
                <input type="date" id="date" wire:model.defer="date" class="mt-1 block w-full border-gray-300 rounded"
                    required>
                @error('date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700">Kezdés</label>
                <input type="time" id="start_time" wire:model.defer="start_time"
                    class="mt-1 block w-full border-gray-300 rounded" required>
                @error('start_time')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700">Befejezés</label>
                <input type="time" id="end_time" wire:model.defer="end_time"
                    class="mt-1 block w-full border-gray-300 rounded" required>
                @error('end_time')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Hozzáadás
            </button>
        </div>
    </form>

    <!-- Meglévő elérhetőségi sávok listája -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-medium mb-4">Meglévő elérhetőségek</h2>

        @if($availabilitySlots->isEmpty())
            <p class="text-gray-500">Nincs elérhetőség beállítva.</p>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Dátum</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Kezdés</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Befejezés</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($availabilitySlots as $slot)
                        <tr>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($slot->start_time)->format('Y-m-d') }}
                            </td>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                            </td>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                            </td>
                            <td class="px-4 py-2 text-right">
                                <button wire:click="destroy({{ $slot->slot_id }})"
                                    class="text-red-600 hover:text-red-800 text-sm">
                                    Törlés
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Foglalások listázása -->
    <div class="bg-white p-6 rounded shadow mt-6">
        <h2 class="text-lg font-medium mb-4">Foglalások</h2>

        @if($appointments->isEmpty())
            <p class="text-gray-500">Nincsenek foglalások.</p>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Időpont</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Vendég</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Szolgáltatás</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($appointments as $appointment)
                        <tr>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('Y-m-d H:i') }}
                            </td>
                            <td class="px-4 py-2">{{ $appointment->customer->name }}</td>
                            <td class="px-4 py-2">{{ $appointment->service->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
