<?php

namespace App\Livewire\Pastorals;

use App\Models\Pastoral;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Show extends Component
{
    public $pastoralId;

    public function mount($pastoral)
    {
        $this->pastoralId = $pastoral;
    }

    #[Computed('pastoral')]
    public function getPastoralProperty()
    {
        return Pastoral::query()
            ->with('user')
            ->withCount('questions')
            ->findOrFail($this->pastoralId);
    }

    public function render()
    {
        return view('livewire.pastorals.show')
            ->title($this->pastoral->name);
    }
}
