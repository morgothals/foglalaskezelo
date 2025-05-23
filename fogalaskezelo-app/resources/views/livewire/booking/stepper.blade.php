<div class="bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">

        ```
        {{-- Siker‐üzenet --}}
        @if ($successMessage)
            <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                {{ $successMessage }}
            </div>

            <script>
                window.scrollTo({ top: 0, behavior: 'smooth' });
            </script>
        @endif

        <form wire:submit.prevent="submitAppointment">
            <div class="text-center">
                <h2 class="text-lg font-semibold text-gray-900">Kövesd a lépéseket a foglalás leadásához</h2>
            </div>

            <div class="mt-10">
                <div class="flex flex-col space-y-8">
                    {{-- Step 1: Szolgáltatás kiválasztása --}}
                    <div>
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center font-bold">
                                1</div>
                            <h3 class="text-lg font-medium text-gray-900">Válassz szolgáltatást</h3>
                        </div>
                        <div class="mt-4">
                            <select wire:change="onServiceSelected($event.target.value)"
                                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-red-500">
                                <option value="">-- Szolgáltatás kiválasztása --</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->service_id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Step 2: Munkatárs kiválasztása --}}
                    <div class="{{ $selectedService ? '' : 'opacity-50 pointer-events-none' }}">
                        <div class="flex items-center space-x-3 mt-4">
                            <div
                                class="w-8 h-8 rounded-full {{ $selectedService ? 'bg-red-600 text-white' : 'bg-gray-400 text-white' }} flex items-center justify-center font-bold">
                                2</div>
                            <h3 class="text-lg font-medium text-gray-900">Válassz munkatársat</h3>
                        </div>
                        <div class="mt-4">
                            <select wire:change="onHairdresserSelected($event.target.value)"
                                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-red-500">
                                <option value="">-- Munkatárs kiválasztása --</option>
                                @foreach ($hairdressers as $hairdresser)
                                    <option value="{{ $hairdresser->hairdresser_id }}">{{ $hairdresser->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Step 3: Időpont kiválasztása --}}
                    <div class="{{ $selectedHairdresser ? '' : 'opacity-50 pointer-events-none' }}">
                        <div class="flex items-center space-x-3 mt-4">
                            <div
                                class="w-8 h-8 rounded-full {{ $selectedHairdresser ? 'bg-red-600 text-white' : 'bg-gray-400 text-white' }} flex items-center justify-center font-bold">
                                3</div>
                            <h3 class="text-lg font-medium text-gray-900">Válassz időpontot</h3>
                        </div>
                        <div class="mt-4">
                            <select wire:model="selectedSlot" wire:change="onSlotSelected($event.target.value)"
                                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-red-500">
                                <option value="">-- Időpont kiválasztása --</option>
                                @foreach ($availabilitySlots as $slot)
                                    <option value="{{ $slot->slot_id }}">
                                        {{ \Carbon\Carbon::parse($slot->start_time)->format('Y-m-d H:i') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Step 4: Adatok megadása és küldés --}}
                    <div>
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 rounded-full {{ $selectedSlot ? 'bg-red-600' : 'bg-gray-300' }} text-white flex items-center justify-center font-bold">
                                4</div>
                            <h3 class="text-lg font-medium text-gray-900">Add meg az adataidat</h3>
                        </div>
                        <div class="mt-4 space-y-4 {{ !$selectedSlot ? 'opacity-50 pointer-events-none' : '' }}">
                            <div>
                                <label class="block text-sm font-medium">Név</label>
                                <input wire:model.defer="clientName" type="text"
                                    class="w-full border border-gray-300 rounded px-4 py-2" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium">E-mail</label>
                                <input wire:model.defer="clientEmail" type="email"
                                    class="w-full border border-gray-300 rounded px-4 py-2" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Telefon</label>
                                <input wire:model.defer="clientPhone" type="tel"
                                    class="w-full border border-gray-300 rounded px-4 py-2" required>
                            </div>
                            <div class="flex items-center">
                                <input wire:model="acceptPolicy" type="checkbox" class="mr-2" id="policy" required>
                                <label for="policy" class="text-sm">
                                    Elfogadom az <a href="/shop/create-salon/policy" class="underline text-blue-600"
                                        target="_blank">Adatvédelmi nyilatkozatot</a>
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input wire:model="saveDetails" type="checkbox" class="mr-2" id="saveDetails">
                                <label for="saveDetails" class="text-sm">Foglalási adatok megjegyzése</label>
                            </div>
                            <div>
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                    Foglalás
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    ```

</div>

<script>
    Livewire.on('scrollToTop', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>
