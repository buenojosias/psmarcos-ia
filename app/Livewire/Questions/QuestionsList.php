<?php

namespace App\Livewire\Questions;

use App\Services\DeleteQuestionService;
use App\Services\VectorizeQuestionService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class QuestionsList extends Component
{
    use Interactions;

    public $resource;
    public $model;
    public $selectedQuestions = [];
    public $vectorizing = false;

    public function mount($resource, $model)
    {
        $this->resource = $resource;
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
        if (count($this->selectedQuestions) == 0) {
            $this->toast()->warning('Nenhuma pergunta selecionada', 'Selecione pelo menos uma pergunta para treinar o agente.')->send();
            return;
        }

        foreach ($this->selectedQuestions as $questionId) {
            $question = $this->model->questions()->where('id', $questionId)->first();

            if (!$question) {
                return;
            }
            if (VectorizeQuestionService::vectorize($this->resource, $this->model, $question)) {
                $question->status = 'processed';
                $question->save();
                $this->selectedQuestions = array_diff($this->selectedQuestions, [$questionId]);
                $this->vectorizing = false;
            }
        }
    }

    public function delete($questionId)
    {
        // fazer confirmação

        if (DeleteQuestionService::execute((int) $questionId)) {
            $this->toast()->success('Pergunta excluída com sucesso.')->send();
        } else {
            $this->toast()->error('Erro ao excluir a pergunta.')->send();
        }
    }

    public function deleteSelected()
    {
        if (count($this->selectedQuestions) == 0) {
            $this->toast()->warning('Nenhuma pergunta selecionada', 'Selecione pelo menos uma pergunta para excluir.')->send();
            return;
        }

        $this->model->questions()
            ->whereIn('id', $this->selectedQuestions)
            ->delete();

        $this->toast()->success('Perguntas excluídas com sucesso.')->send();

        $this->selectedQuestions = [];
    }
}
