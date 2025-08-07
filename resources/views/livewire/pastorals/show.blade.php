<div class="flex flex-col md:flex-row gap-4">
    <div class="flex-1">
        <x-ts-card header="Sobre">
            <p class="mb-4 pb-4 border-b border-gray-200">
                <strong>Coordenador(a)</strong><br>
                {{ $this->pastoral->user->name ?? 'Coordenador(a) não informado(a)' }}
            </p>
            <p><strong>Descrição</strong><br>
                {{ $this->pastoral->description ?? 'Descrição não disponível' }}
            </p>
        </x-ts-card>
    </div>
    <div class="w-full md:w-2/3 space-y-4">
        <livewire:pastorals.questions :pastoral="$this->pastoral" />
        <livewire:pastorals.questions-create :pastoral="$this->pastoral" />
    </div>
</div>
