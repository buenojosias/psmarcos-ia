<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Computed('events')]
    public function getEventsProperty()
    {
        $events = Event::with('eventable')->paginate();
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
            ['index' => 'eventable.name', 'label' => 'Vinculado a'],
            ['index' => 'action'],
        ];

        $rows = $this->events->sortBy('starts_at');

        return view('livewire.events.index', compact('headers', 'rows'))
            ->title('Eventos');
    }
}
