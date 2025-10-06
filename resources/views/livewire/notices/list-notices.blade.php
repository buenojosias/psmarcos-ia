<div>
    <x-ts-card header="Avisos" class="divide-y">
        @forelse ($this->notices as $notice)
            <div class="py-3 flex justify-between items-center gap-4">
                <div>
                    <p>{{ $notice->content }}</p>
                    <p class="text-sm text-gray-800 dark:text-gray-200">Válido até:
                        {{ \Carbon\Carbon::parse($notice->expires_at)->format('d/m/Y') }}</p>
                </div>
                <div>
                    <x-ts-button icon="trash" x-on:click="$dispatch('delete-notice', { notice: {{ $notice->id }} })" color="red" flat sm />
                </div>
            </div>
        @empty
            <p>Nenhum aviso cadastrado.</p>
        @endforelse
        <x-slot:footer>
            <livewire:notices.create :resource="$resource" :model="$model" @saved="$refresh" />
        </x-slot>
    </x-ts-card>
    <livewire:notices.delete @deleted="$refresh" />
</div>
