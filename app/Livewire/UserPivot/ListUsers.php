<?php

namespace App\Livewire\UserPivot;

use Livewire\Attributes\Computed;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class ListUsers extends Component
{
    use Interactions;

    public $resource;
    public $model;

    public function mount($resource, $model)
    {
        $this->resource = $resource;
        $this->model = $model;
    }

    #[Computed('users')]
    public function getUsersProperty()
    {
        return $this->model->users;
    }

    public function render()
    {
        return view('livewire.user-pivot.list-users');
    }

    public function toggleLeader($userId)
    {
        $this->dialog()
            ->question('Alterar função de coordenador?')
            ->confirm(method: 'confirmToggleLeader', params: $userId)
            ->cancel('Cancelar')
            ->send();
    }

    public function confirmToggleLeader($userId)
    {
        if (
            $this->model->users()->updateExistingPivot(
                $userId,
                ['is_leader' => !$this->model->users->find($userId)->pivot->is_leader]
            )
        ) {
            $this->users = $this->model->fresh()->users;
            $this->toast()->success('Função de coordenador alterada com sucesso.')->send();
        } else {
            $this->toast()->error('Erro ao alterar função de coordenador.')->send();
        }
    }

    public function detachUser($userId)
    {
        $this->dialog()
            ->question('Desvincular usuário?')
            ->confirm(method: 'confirmDetachUser', params: $userId)
            ->cancel('Cancelar')
            ->send();
    }

    public function confirmDetachUser($userId)
    {
        if ($this->model->users()->detach($userId)) {
            $this->toast()->success('Usuário desvinculado com sucesso.')->send();
        } else {
            $this->toast()->error('Erro ao desvincular usuário.')->send();
        }
    }
}
