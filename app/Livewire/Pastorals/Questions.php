<?php

namespace App\Livewire\Pastorals;

use App\Services\VectorizePastoralQuestions;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Questions extends Component
{
    use Interactions;

    public $pastoral;
    public $selectedQuestions = [];

    public function mount($pastoral)
    {
        $this->pastoral = $pastoral;
    }

    #[Computed()]
    public function getQuestionsProperty()
    {
        return $this->pastoral->questions()->get();
    }

    #[On('questionCreated')]
    public function refreshQuestions()
    {
        $this->pastoral->load('questions');
    }

    public function render()
    {
        return view('livewire.pastorals.questions');
    }

    public function vectorize()
    {
        $vectorized = VectorizePastoralQuestions::handle($this->pastoral, $this->selectedQuestions);
    }

    public function deleteSelected()
    {
        // excluir do vetor
        $this->pastoral->questions()
            ->whereIn('id', $this->selectedQuestions)
            ->delete();

        $this->toast()->success('Perguntas excluídas com sucesso.')->send();

        $this->selectedQuestions = [];
    }
}
