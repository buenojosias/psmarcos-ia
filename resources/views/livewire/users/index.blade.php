<div class="space-y-4">
    <livewire:users.create @saved="$refresh" />
    <x-ts-table :$headers :$rows>
        @interact('column_user_name', $row)
            <a href="{{ route('users.show', $row) }}">{{ $row->name }}</a>
        @endinteract
        @interact('column_user_roles', $row)
            @foreach ($row->roles ?? [] as $role)
                <x-ts-badge :text="\App\Enums\UserRoleEnum::from($role)->getLabel()" color="gray" />
            @endforeach
        @endinteract
    </x-ts-table>
</div>
