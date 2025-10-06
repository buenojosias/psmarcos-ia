<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Index extends Component
{
    #[Computed('users')]
    public function getUsersProperty()
    {
        $users = User::orderBy('name')->get();

        return $users;
    }

    public function render()
    {
        $headers = [
            ['index' => 'user_name', 'label' => 'Nome'],
            ['index' => 'user_role', 'label' => 'Função(ões)'],
        ];

        $rows = $this->users;

        return view('livewire.users.index', compact('headers', 'rows'))
            ->title('Usuários');
    }
}
