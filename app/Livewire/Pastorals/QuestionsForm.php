<?php

namespace App\Livewire\Pastorals;

use Livewire\Component;

class QuestionsForm extends Component
{
    public $pastoral;
    public $question;
    public $index;

    public function mount($pastoral, $question = [], $index = 0)
    {
        $this->pastoral = $pastoral;
        $this->question = $question;
        $this->index = $index;
    }

    public function render()
    {
        return view('livewire.pastorals.questions-form');
    }
}
