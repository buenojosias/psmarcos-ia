<?php

namespace App\Livewire\Pastorals;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class AttachUser extends Component
{
    use Interactions;

    public $pastoral;
    public $users = [];
    public $user_id;

    public function mount($pastoral)
    {
        $this->pastoral = $pastoral;
    }

    #[On('load-users')]
    public function loadUsers()
    {
        if (empty($this->users)) {
            $this->users = User::query()
                ->orderBy('name')
                ->whereJsonDoesntContain('roles', 'admin')
                ->whereDoesntHave('pastorals', function ($query) {
                    $query->where('pastoral_id', $this->pastoral->id);
                })
                ->get()
                ->toArray();
        }
    }

    public function render()
    {
        return view('livewire.pastorals.attach-user');
    }

    public function attach()
    {
        try {
            $this->pastoral->users()->syncWithoutDetaching($this->user_id);
            $this->toast()->success('Usuário(a) vinculado(a) à pastoral com sucesso!')->send();
            $this->dispatch('attached');
            $this->reset('user_id');
        } catch (\Throwable $th) {
            $this->toast()->error('Erro ao vincular usuário(a) à pastoral.')->send();
        }
    }
}
