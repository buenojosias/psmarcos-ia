<?php

namespace App\Livewire\Services;

use Livewire\Attributes\On;
use Livewire\Component;
use Str;
use TallStackUi\Traits\Interactions;

class Edit extends Component
{
    use Interactions;

    public $service;
    public $name;
    public $description;

    public function mount($service)
    {
        $this->service = $service;
        $this->name = $this->service->name;
        $this->description = $this->service->description;
    }

    public function render()
    {
        return view('livewire.services.edit');
    }

    public function save()
    {
        $data = $this->validate([
            'name' => 'required|string|max:130|unique:services,name,' . $this->service->id,
            'description' => 'nullable|string',
        ], attributes: [
            'name' => 'nome',
            'description' => 'descrição',
        ]);
        if ($data['description'] == '') {
            $data['description'] = null;
        }
        $data['alias'] = Str::slug($data['name'], '_');

        if ($this->service->update($data)) {
            $this->toast()
                ->success('Serviço atualizado com sucesso.')
                ->flash()
                ->send();

            return $this->redirect(route('services.show', $data['alias']));
        }
    }
}
