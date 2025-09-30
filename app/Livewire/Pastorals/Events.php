<?php

namespace App\Livewire\Pastorals;

use App\Models\Pastoral;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Events extends Component
{
    public $pastoral;

    public function mount(Pastoral $pastoral)
    {
        $this->pastoral = $pastoral;
    }

    #[Computed('events')]
    public function getEventsProperty()
    {
        $events = $this->pastoral->events;
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

        return view('livewire.pastorals.events', compact('headers', 'rows'))
            ->title($this->pastoral->name);
    }
}
