<?php

namespace App\Livewire\Events;

use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Delete extends Component
{
    use Interactions;

    public $event;

    public function mount($event)
    {
        $this->event = $event;
    }

    public function render()
    {
        return view('livewire.events.delete');
    }

    public function delete()
    {
        $this->dialog()
            ->question('Deseja realmente excluir este evento?')
            ->confirm(method: 'confirmed')
            ->cancel()
            ->send();
    }

    public function confirmed()
    {
        $questions = $this->event->questions();
        $notices = $this->event->notices();
        $documents = \App\Models\Document::query()
            ->where(function ($q) use ($questions) {
                $q->where('resource', 'event')
                ->whereIn('model_id', $questions->pluck('id'));
            })
            ->orWhere(function ($q) use ($notices) {
                $q->where('resource', 'aviso')
                ->whereIn('model_id', collect($notices)->pluck('id'));
            })
            ->delete();

        $this->event->questions()->delete();
        $this->event->notices()->delete();

        $this->event->delete();
        $this->toast()
            ->success('Evento excluído com sucesso.')
            ->flash()
            ->send();

        return $this->redirect(route('events.index'));
    }
}
