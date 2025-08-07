<?php

namespace App\Livewire\Pastorals;

use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class QuestionsCreate extends Component
{
    use Interactions;

    public $pastoral;
    public $questions;
    public $qa;

    public function mount($pastoral)
    {
        $this->pastoral = $pastoral;
        $this->questions = collect([
            [
                'id' => rand(1000, 9000),
                'question' => '',
                'answer' => '',
            ],
        ])->toArray();
        // $this->addQuestion();
    }

    public function render()
    {
        return view('livewire.pastorals.questions-create');
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'id' => rand(1000, 9000),
            'question' => '',
            'answer' => '',
        ];
    }

    #[On('addSuggestion')]
    public function addSuggestion($question)
    {
        $this->questions[] = [
            'id' => rand(1000, 9000),
            'question' => $question,
            'answer' => '',
        ];
    }

    public function saveQuestion($id)
    {
        $this->resetValidation();
        $this->qa = $this->questions[array_search($id, array_column($this->questions, 'id'))];

        // Substituir ## pelo pastoral->name
        $this->qa['question'] = str_replace('##', $this->pastoral->name, $this->qa['question']);
        $this->qa['answer'] = str_replace('##', $this->pastoral->name, $this->qa['answer']);

        dump($this->qa);

        return;

        $data = $this->validate([
            'qa.question' => 'required|string|max:255',
            'qa.answer' => 'required|string|max:255',
        ]);
        $data['qa']['pastoral_id'] = $this->pastoral->id;

        $created = $this->pastoral->questions()->create($data['qa']);
        if ($created) {
            $this->reset('qa');
            $this->toast()->success('Pergunta criada com sucesso!')->send();
            $this->removeQuestion($id);
            $this->dispatch('questionCreated');
        }
    }

    public function removeQuestion($id)
    {
        unset($this->questions[array_search($id, array_column($this->questions, 'id'))]);
        // $this->questions = array_values($this->questions);
    }
}
