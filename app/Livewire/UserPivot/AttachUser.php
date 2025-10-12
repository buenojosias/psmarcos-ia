<?php

namespace App\Livewire\UserPivot;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class AttachUser extends Component
{
    use Interactions;

    public $resource;
    public $model;
    public $users = [];
    public $user_id;

    public function mount($resource, $model)
    {
        $this->resource = $resource;
        $this->model = $model;
    }

    #[On('load-users')]
    public function loadUsers()
    {
        if (empty($this->users)) {
            $this->users = User::query()
                ->orderBy('name')
                ->whereJsonDoesntContain('roles', 'admin')
                ->when($this->resource === 'communities', function ($query) {
                    $query->whereDoesntHave('communities', fn($query) => $query->where('community_id', $this->model->id));
                })
                ->when($this->resource === 'pastorals', function ($query) {
                    $query->whereDoesntHave('pastorals', fn($query) => $query->where('pastoral_id', $this->model->id));
                })
                ->get()
                ->toArray();
        }
    }

    public function render()
    {
        return view('livewire.user-pivot.attach-user');
    }

    public function attach()
    {
        try {
            $this->model->users()->syncWithoutDetaching($this->user_id);
            $this->toast()->success('Usuário(a) vinculado(a).')->send();
            $this->dispatch('attached');
            $this->reset('user_id');
        } catch (\Throwable $th) {
            $this->toast()->error('Erro ao vincular usuário(a).')->send();
        }
    }
}
