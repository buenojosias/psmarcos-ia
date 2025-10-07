<?php

namespace App\Livewire\Pastorals;

use App\Models\Community;
use App\Models\Pastoral;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Str;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Interactions;

    public $name;
    public $user_id;
    public $community_id;
    public $description;

    public $communities = [];
    public $users = [];

    public function mount($community_id = null)
    {
        $this->community_id = $community_id;
    }

    #[On('modalOpened')]
    public function modalOpened()
    {
        if (is_null($this->community_id) && empty($this->communities)) {
            $this->communities = Community::all()->toArray();
            $this->communities = array_merge([['id' => null, 'name' => 'Selecione uma comunidade']], $this->communities);
        }
        if (empty($this->users)) {
            $this->users = User::select('id', 'name')->orderBy('name')->get()->toArray();
            $this->users = array_merge([['id' => null, 'name' => 'Selecione um usuário']], $this->users);
        }
    }

    public function render()
    {
        return view('livewire.pastorals.create');
    }

    public function save()
    {
        $data = $this->validate([
            'name' => 'required|string|max:130',
            'user_id' => 'nullable|exists:users,id',
            'community_id' => 'nullable|exists:communities,id',
            'description' => 'nullable|string',
        ], attributes: [
            'name' => 'nome',
            'user_id' => 'coordenador(a)',
            'community_id' => 'comunidade',
            'description' => 'descrição',
        ]);
        $data['slug'] = Str::slug($data['name'], '_');

        $pastoral = Pastoral::create($data);

        if ($pastoral) {
            $this->toast()->success('Grupo, movimento ou pastoral adicionado com sucesso!')->send();
            $this->dispatch('saved');
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'user_id',
            'description',
        ]);
    }
}
