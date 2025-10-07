<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Edit extends Component
{
    use Interactions;

    public $event;
    public $name;
    public $start_date;
    public $start_time;
    public $end_date;
    public $end_time;
    public $starts_at;
    public $ends_at;
    public $location;
    public $description;

    public function mount($event)
    {
        $this->event = $event;
        $this->name = $this->event->name;
        $this->start_date = date('Y-m-d', strtotime($this->event->starts_at));
        $this->start_time = $this->event->starts_at ? date('H:i', strtotime($this->event->starts_at)) : null;
        $this->end_date = $this->event->ends_at ? date('Y-m-d', strtotime($this->event->ends_at)) : null;
        $this->end_time = $this->event->ends_at ? date('H:i', strtotime($this->event->ends_at)) : null;
        $this->location = $this->event->location;
        $this->description = $this->event->description;
    }

    public function save()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'end_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], attributes: [
            'name' => 'nome',
            'start_date' => 'data de início',
            'start_time' => 'horário de início',
            'end_date' => 'data de término',
            'end_time' => 'horário de término',
            'location' => 'local',
            'description' => 'descrição',
        ]);

        $this->starts_at = date('Y-m-d H:i:s', strtotime($this->start_date . ' ' . $this->start_time));
        if ($this->end_date && $this->end_time) {
            $this->ends_at = date('Y-m-d H:i:s', strtotime($this->end_date . ' ' . $this->end_time));
        } elseif ($this->end_date) {
            $this->ends_at = date('Y-m-d H:i:s', strtotime($this->end_date . ' 23:59:59'));
        } else {
            $this->ends_at = null;
        }

        $data['starts_at'] = $this->starts_at;
        $data['ends_at'] = $this->ends_at;

        if ($data['description'] == '') {
            $data['description'] = null;
        }

        if ($this->event->update($data)) {
            $this->dispatch('saved')->self();
            $this->toast()->success('Evento adicionado com sucesso.')->send();
        }
    }

    public function render()
    {
        return view('livewire.events.edit');
    }
}
