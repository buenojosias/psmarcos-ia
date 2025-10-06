<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Interactions;

    public $name;
    public $email;
    public $password;
    public $roles = [];
    public $roleOptions = [
        [ 'value' => 'coordinator', 'label' => 'Coordenador(a) de pastoral', ],
        [ 'value' => 'secretary', 'label' => 'Secretário(a)', ],
        [ 'value' => 'pascom', 'label' => 'Pasconeiro(a)', ],
        [ 'value' => 'admin', 'label' => 'Administrador', ],
    ];

    public function render()
    {
        return view('livewire.users.create');
    }

    public function save()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'roles' => 'required|array|min:1',
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        if ($user) {
            $this->toast()->success('Usuário cadastrado com sucesso!')->send();
            $this->dispatch('saved');
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'password', 'roles']);
    }
}
