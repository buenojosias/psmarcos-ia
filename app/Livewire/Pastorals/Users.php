<?php

namespace App\Livewire\Pastorals;

use Livewire\Attributes\Computed;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Users extends Component
{
    use Interactions;

    public $pastoral;

    public function mount($pastoral)
    {
        $this->pastoral = $pastoral;
    }

    #[Computed('users')]
    public function getUsersProperty()
    {
        return $this->pastoral->users;
    }

    public function render()
    {
        return view('livewire.pastorals.users');
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
            $this->pastoral->users()->updateExistingPivot(
                $userId,
                ['is_leader' => !$this->pastoral->users->find($userId)->pivot->is_leader]
            )
        ) {
            $this->users = $this->pastoral->fresh()->users;
            $this->toast()->success('Função de líder alterada com sucesso!')->send();
        } else {
            $this->toast()->error('Erro ao alterar função de líder!')->send();
        }
    }

    public function detachUser($userId)
    {
        $this->dialog()
            ->question('Desvincular usuário da pastoral?')
            ->confirm(method: 'confirmDetachUser', params: $userId)
            ->cancel('Cancelar')
            ->send();
    }

    public function confirmDetachUser($userId)
    {
        if ($this->pastoral->users()->detach($userId)) {
            $this->toast()->success('Usuário desvinculado da pastoral com sucesso!')->send();
        } else {
            $this->toast()->error('Erro ao desvincular usuário da pastoral!')->send();
        }
    }
}
