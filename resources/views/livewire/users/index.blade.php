<div class="space-y-4">
    <livewire:users.create @saved="$refresh" />
    <x-ts-table :$headers :$rows>
        @interact('column_user_name', $row)
            <a href="{{ route('users.show', $row) }}">{{ $row->name }}</a>
        @endinteract
    </x-ts-table>
</div>
