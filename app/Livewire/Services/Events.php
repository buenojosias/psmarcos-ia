<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Events extends Component
{
    public $service;

    public function mount(Service $service)
    {
        $this->service = $service;
    }

    #[Computed('events')]
    public function getEventsProperty()
    {
        $events = $this->service->events;
        $events->map(function ($event) {
            $event->date = Carbon::parse($event->starts_at)->format('d/m/Y');
            return $event;
        });

        return $events;
    }

    public function render()
    {
        $headers = [
            ['index' => 'event_name', 'label' => 'Nome do evento'],
            ['index' => 'date', 'label' => 'Data'],
            ['index' => 'action'],
        ];

        $rows = $this->events->sortBy('starts_at');

        return view('livewire.services.events', compact('headers', 'rows'))
            ->title('Eventos');
    }
}
