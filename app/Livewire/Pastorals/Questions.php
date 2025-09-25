<?php

namespace App\Livewire\Pastorals;

use App\Models\Pastoral;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Questions extends Component
{
    public $pastoralId;

    public function mount($pastoral)
    {
        $this->pastoralId = $pastoral;
    }

    #[Computed('pastoral')]
    public function getPastoralProperty()
    {
        return Pastoral::with('user')->findOrFail($this->pastoralId);
    }

    public function render()
    {
        return view('livewire.pastorals.questions')
            ->title($this->pastoral->name);
    }
}
