<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $headers = [
            ['index' => 'name', 'label' => 'Nome'],
            ['index' => 'role', 'label' => 'Função'],
        ];

        $rows = User::orderBy('name')->get();

        return view('livewire.users.index', compact('headers', 'rows'))
            ->title('Usuários');
    }
}
