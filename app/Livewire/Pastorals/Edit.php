<?php

namespace App\Livewire\Pastorals;

use App\Models\Community;
use App\Models\Pastoral;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Str;
use TallStackUi\Traits\Interactions;

class Edit extends Component
{
    use Interactions;

    public $pastoral;
    public $name;
    public $user_id;
    public $community_id;
    public $description;

    public $communities = [];
    public $users = [];

    public function mount($pastoral)
    {
        $this->pastoral = $pastoral;
    }

    #[On('modalOpened')]
    public function modalOpened()
    {
        if (empty($this->communities)) {
            $this->communities = Community::all()->toArray();
            $this->communities = array_merge([['id' => null, 'name' => 'Selecione uma comunidade']], $this->communities);
        }
        if (empty($this->users)) {
            $this->users = User::select('id', 'name')->orderBy('name')->get()->toArray();
            $this->users = array_merge([['id' => null, 'name' => 'Selecione um usuário']], $this->users);
        }

        $this->user_id = $this->pastoral->user_id;
        $this->community_id = $this->pastoral->community_id;
        $this->name = $this->pastoral->name;
        $this->description = $this->pastoral->description;
    }

    public function render()
    {
        return view('livewire.pastorals.edit');
    }

    public function save()
    {
        $data = $this->validate([
            'name' => 'required|string|max:130',
            'user_id' => 'nullable|exists:users,id',
            'community_id' => 'nullable|exists:communities,id',
            'description' => 'nullable|string|max:255',
        ]);
        if ($data['description'] == '') {
            $data['description'] = null;
        }
        $data['slug'] = Str::slug($data['name'], '_');

        // $pastoral = Pastoral::findOrFail($this->pastoral->id)->update($data);

        if ($this->pastoral->update($data)) {
            $this->toast()->success('Alterações salvas com sucesso!')->send();
            $this->dispatch('saved');
        }
    }
}
