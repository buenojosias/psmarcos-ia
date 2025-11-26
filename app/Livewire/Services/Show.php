<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Show extends Component
{
    public $serviceAlias;

    public function mount($service)
    {
        $this->serviceAlias = $service;
    }

    #[Computed('service')]
    public function getServiceProperty()
    {
        return Service::query()
            ->withCount(['questions', 'events'])
            ->where('alias', $this->serviceAlias)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.services.show')
            ->title('Serviços');
    }
}
