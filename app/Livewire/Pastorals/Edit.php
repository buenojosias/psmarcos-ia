<?php

namespace App\Livewire\Pastorals;

use App\Models\Community;
use Livewire\Attributes\On;
use Livewire\Component;
use Str;
use TallStackUi\Traits\Interactions;

class Edit extends Component
{
    use Interactions;

    public $pastoral;
    public $name;
    public $community_id;
    public $description;

    public $communities = [];

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
            'community_id' => 'nullable|exists:communities,id',
            'description' => 'nullable|string',
        ], attributes: [
            'name' => 'nome',
            'community_id' => 'comunidade',
            'description' => 'descrição',
        ]);
        if ($data['community_id'] == '') {
            $data['community_id'] = null;
        }
        if ($data['description'] == '') {
            $data['description'] = null;
        }
        $data['slug'] = Str::slug($data['name'], '_');

        if ($this->pastoral->update($data)) {
            $this->toast()->success('Alterações salvas com sucesso.')->send();
            $this->dispatch('saved');
        }
    }
}
