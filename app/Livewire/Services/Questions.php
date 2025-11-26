<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;

class Questions extends Component
{
    public $service;

    public function mount(Service $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        return view('livewire.services.questions')
            ->title('Perguntas e respostas');
    }
}
