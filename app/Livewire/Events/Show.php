<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Show extends Component
{
    public $eventId;

    public function mount($event)
    {
        $this->eventId = $event;
    }

    #[Computed('event')]
    public function getEventProperty()
    {
        return Event::query()
            ->with('eventable')
            ->findOrFail($this->eventId);
    }

    public function render()
    {
        $route_name = \Str::plural($this->event->eventable_type) . '.show';
        return view('livewire.events.show', compact('route_name'))
            ->title('Evento');
    }
}
