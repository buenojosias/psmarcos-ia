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
        return Pastoral::findOrFail($this->pastoralId);
    }

    public function render()
    {
        return view('livewire.pastorals.questions')
            ->title('Perguntas e respostas');
    }
}
