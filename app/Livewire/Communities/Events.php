<?php

namespace App\Livewire\Communities;

use App\Models\Community;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Events extends Component
{
    public $community;

    public function mount(Community $community)
    {
        $this->community = $community;
    }

    #[Computed('events')]
    public function getEventsProperty()
    {
        $events = $this->community->events;
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

        return view('livewire.communities.events', compact('headers', 'rows'))
            ->title('Eventos');
    }
}
