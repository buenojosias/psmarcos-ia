<div class="space-y-4">
    <livewire:users.create @saved="$refresh" />
    <x-ts-table :$headers :$rows />
</div>
