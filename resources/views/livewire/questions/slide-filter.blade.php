<x-ts-slide id="filter-slide" title="Filtrar perguntas e respostas" size="sm">
    <div class="divide-y">
        <div class="py-4">
            <x-ts-toggle wire:model="onlyUnprocessed" label="Apenas não processadas" />
        </div>
        <div class="py-4">
            <x-ts-select.native wire:model="questionable" label="Tipo">
                @foreach ($questionableTypes as $type)
                    <option value="{{ $type['value'] }}">{{ ucfirst($type['label']) }}</option>
                @endforeach
            </x-ts-select>
        </div>
    </div>

    <x-slot:footer>
        <x-ts-button wire:click="submit" text="Aplicar" />
    </x-slot>
</x-ts-slide>
@script
    <script>
        $wire.on('slideClose', () => {
            $slideClose('filter-slide');
        });
    </script>
@endscript
