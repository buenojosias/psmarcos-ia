<x-ts-card header="Excluir evento" minimize="mount">
    Ao excluir este evento, todas as informações relacionadas a ele, como perguntas, respostas e avisos, serão permanentemente removidas do sistema. Esta ação é irreversível.
    <x-slot:footer>
        <x-ts-button text="Confirmar exclusão" wire:click="delete" color="red" />
    </x-slot>
</x-ts-card>
