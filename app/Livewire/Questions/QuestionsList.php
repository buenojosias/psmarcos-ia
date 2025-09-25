<?php

namespace App\Livewire\Questions;

use App\Services\VectorizePastoralQuestions;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class QuestionsList extends Component
{
    use Interactions;

    public $model;
    public $selectedQuestions = [];

    public function mount($model)
    {
        $this->model = $model;
    }

    #[Computed()]
    public function getQuestionsProperty()
    {
        return $this->model->questions()->get();
    }

    #[On('questionCreated')]
    public function refreshQuestions()
    {
        $this->model->load('questions');
    }

    public function render()
    {
        return view('livewire.questions.questions-list');
    }

    public function vectorize()
    {
        $vectorized = VectorizePastoralQuestions::handle($this->model, $this->selectedQuestions);
    }

    public function deleteSelected()
    {
        $this->model->questions()
            ->whereIn('id', $this->selectedQuestions)
            ->delete();

        $this->toast()->success('Perguntas excluídas com sucesso.')->send();

        $this->selectedQuestions = [];
    }
}
