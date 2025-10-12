<?php

namespace App\Livewire\UserPivot;

use App\Models\User;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class CreateUser extends Component
{
    use Interactions;

    public $model;
    public $name;
    public $email;
    public $password;
    public $roles = ['coordinator'];

    public function mount($model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.user-pivot.create-user');
    }

    public function save()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'roles' => 'required|array|min:1',
        ], attributes: [
            'name' => 'nome',
            'email' => 'e-mail',
            'password' => 'senha',
            'roles' => 'funções',
        ]);
        $data['password'] = bcrypt($data['password']);
        $data['created_by'] = auth()->id();

        $user = User::create($data);

        if ($user) {
            $this->model->users()->attach($user->id);
            $this->toast()->success('Usuário cadastrado e vinculado com sucesso.')->send();
            $this->dispatch('saved');
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'password']);
    }
}
