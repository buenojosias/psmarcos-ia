<?php

namespace App\Livewire\Questions;

use Livewire\Component;

class GuestList extends Component
{
    public $questions;

    public function mount($model)
    {
        $this->questions = $model->questions;
    }

    public function render()
    {
        return view('livewire.questions.guest-list');
    }
}
