<?php

namespace App\Livewire\Questions;

use App\Models\Question;
use App\Services\DeleteQuestionService;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Edit extends Component
{
    use Interactions;

    public $model;
    public $question_model;
    public $question;
    public $answer;
    public $status;

    public function mount($model)
    {
        $this->model = $model;
    }

    #[On('edit-question')]
    public function loadQuestion(Question $question)
    {
        $this->resetValidation();
        $this->question_model = $question;
        $this->question = $question->question;
        $this->answer = $question->answer;
        $this->status = $question->status;
        $this->dispatch('open-modal')->self();
    }

    public function resetFields()
    {
        $this->reset(['question', 'answer', 'status', 'question_model']);
    }

    public function render()
    {
        return view('livewire.questions.edit');
    }

    public function save()
    {
        // Substituir ## pelo model->name
        $this->question = str_replace('##', $this->model->name, $this->question);
        $this->answer = str_replace('##', $this->model->name, $this->answer);

        $data = $this->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:255',
        ], attributes: [
            'question' => 'pergunta',
            'answer' => 'resposta',
        ]);
        $data['status'] = 'pending';

        $saved = $this->question_model->update($data);
        if ($saved) {
            if ($this->status->value === 'processed') {
                DeleteQuestionService::deleteEmbeded($this->question_model);
            }

            $this->resetFields();
            $this->toast()->success('Pergunta editada com sucesso.')->send();
            $this->dispatch('saved');
        }
    }
}
