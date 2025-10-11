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
        $users = User::orderBy('name')->with('parent')->get();
        $users->map(function ($user) {
            $user->formated_created_at = $user->created_at->format('d/m/Y');

            return $user;
        });

        return $users;
    }

    public function render()
    {
        $headers = [
            ['index' => 'user_name', 'label' => 'Nome'],
            ['index' => 'user_roles', 'label' => 'Função(ões)'],
            ['index' => 'parent.name', 'label' => 'Cadastrado por'],
            ['index' => 'formated_created_at', 'label' => 'Data do cadastro'],
        ];

        $rows = $this->users;

        return view('livewire.users.index', compact('headers', 'rows'))
            ->title('Usuários');
    }
}
