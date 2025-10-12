<?php

namespace App\Livewire\Communities;

use App\Models\Community;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Interactions;

    public $name;
    public $alias;
    public $address;

    public function render()
    {
        return view('livewire.communities.create');
    }

    public function save()
    {
        $this->authorize('create', Community::class);

        $data = $this->validate([
            'name' => 'required|string|max:130',
            'alias' => 'required|string|max:30|unique:communities,alias',
            'address' => 'nullable|string|max:255',
        ], attributes: [
            'name' => 'nome',
            'alias' => 'abreviação',
            'address' => 'endereço',
        ]);

        $community = Community::create($data);

        if ($community) {
            $this->toast()->success('Comunidade adicionada com sucesso!')->send();
            $this->dispatch('saved');
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->reset(['name', 'alias', 'address']);
    }
}
