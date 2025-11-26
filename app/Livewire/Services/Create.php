<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Attributes\On;
use Livewire\Component;
use Str;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Interactions;

    public $name;
    public $description;

    public function render()
    {
        return view('livewire.services.create');
    }

    public function save()
    {
        $data = $this->validate([
            'name' => 'required|string|max:130|unique:services,name',
            'description' => 'nullable|string',
        ], attributes: [
            'name' => 'nome',
            'description' => 'descrição',
        ]);
        $data['alias'] = Str::slug($data['name'], '_');

        if(Service::create($data)) {
            $this->toast()->success('Serviço adicionado com sucesso!')->send();
            $this->dispatch('saved');
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'description',
        ]);
    }
}
