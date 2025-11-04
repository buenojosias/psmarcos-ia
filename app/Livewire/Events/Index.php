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
        $events = Event::with('eventable')->orderBy('starts_at')->paginate();
        $events->map(function ($event) {
            $event->date = Carbon::parse($event->starts_at)->format('d/m/Y');
            $event->route_name = \Str::plural($event->eventable_type);

            return $event;
        });

        return $events;
    }

    public function render()
    {
        $headers = [
            ['index' => 'event_name', 'label' => 'Nome do evento'],
            ['index' => 'date', 'label' => 'Data'],
            ['index' => 'v', 'label' => 'Organizado por'],
            ['index' => 'action'],
        ];

        $rows = $this->events;

        return view('livewire.events.index', compact('headers', 'rows'))
            ->title('Eventos');
    }
}
