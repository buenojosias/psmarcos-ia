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
        return view('livewire.events.show')
            ->title('Evento');
    }
}
