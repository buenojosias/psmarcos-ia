<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Edit extends Component
{
    use Interactions;

    public $user;
    public $name;
    public $email;
    public $password;

    public function mount($user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function render()
    {
        return view('livewire.users.edit');
    }

    public function save()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'password' => 'nullable|string|min:8',
        ], attributes: [
            'name' => 'nome',
            'email' => 'e-mail',
            'password' => 'senha',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if ($this->user->update($data)) {
            $this->toast()->success('Alterações salvas com sucesso!')->send();
            $this->dispatch('saved');
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->reset(['password']);
    }
}
