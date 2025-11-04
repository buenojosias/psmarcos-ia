<div>
    <x-ts-card header="Avisos" class="space-y-3">
        @forelse ($this->notices as $notice)
            <div
                class="p-4 border dark:border-none rounded-lg flex items-center justify-between gap-2 dark:bg-gray-800 shadow-sm">
                <div class="space-y-2">
                    <p class="font-semibold">{{ $notice->content }}</p>
                    <x-ts-badge :text="'Válido até: ' . \Carbon\Carbon::parse($notice->expires_at)->format('d/m/Y')" color="gray" />
                </div>
                @can('manage', $model)
                    <div>
                        <x-ts-button icon="trash" x-on:click="$dispatch('delete-notice', { notice: {{ $notice->id }} })"
                            color="red" flat md />
                    </div>
                @endcan
            </div>
        @empty
            <p>Nenhum aviso cadastrado.</p>
        @endforelse
        @can('manage', $model)
            <x-slot:footer>
                <livewire:notices.create :resource="$resource" :model="$model" @saved="$refresh" />
            </x-slot>
        @endcan
    </x-ts-card>
    @can('manage', $model)
        <livewire:notices.delete @deleted="$refresh" />
    @endcan
</div>
