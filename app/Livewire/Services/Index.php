<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Index extends Component
{
    #[Computed('services')]
    public function services()
    {
        return Service::orderBy('name')->get();
    }

    public function render()
    {
        $services = $this->services();
        return view('livewire.services.index', compact('services'))
            ->title('Serviços');
    }
}
