<?php

namespace App\Livewire\Questions;

use Livewire\Component;

class Form extends Component
{
    public $model;
    public $question;
    public $index;

    public function mount($model, $question = [], $index = 0)
    {
        $this->model = $model;
        $this->question = $question;
        $this->index = $index;
    }

    public function render()
    {
        return view('livewire.questions.form');
    }
}
