<?php

namespace App\Livewire\Questions;

use App\Models\Suggestion;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Interactions;

    public $resource;
    public $model;
    public $question;
    public $answer;
    public $suggestion_id;
    public $suggestions = [];
    public $temp_id;

    public function mount($model, $resource)
    {
        $this->model = $model;
        $this->resource = $resource;
    }

    public function render()
    {
        return view('livewire.questions.create');
    }

    #[On('addSuggestion')]
    public function addSuggestion($suggestion)
    {
        $temp_id = rand(1000, 9000);
        $this->suggestions[] = [
            'question' => is_array($suggestion) ? $suggestion['content'] : $suggestion,
            'answer' => '',
            'suggestion_id' => $suggestion['id'] ?? null,
            'temp_id' => $temp_id,
        ];

        if (empty($this->question)) {
            $this->setSuggestionProperties();
        }
    }

    public function setSuggestionProperties($temp_id = null)
    {
        if ($temp_id) {
            $this->suggestions = array_filter($this->suggestions, function ($s) use ($temp_id) {
                return $s['temp_id'] !== $temp_id;
            });
            $this->suggestions = array_values($this->suggestions);
        }

        $suggestion = $this->suggestions[0] ?? null;
        if ($suggestion) {
            $this->question = $suggestion['question'];
            $this->suggestion_id = $suggestion['suggestion_id'];
            $this->temp_id = $suggestion['temp_id'];
        }
    }

    public function saveQuestion()
    {
        // Substituir ## pelo model->name
        $this->question = str_replace('##', $this->model->name, $this->question);
        $this->answer = str_replace('##', $this->model->name, $this->answer);

        $data = $this->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:255',
            'suggestion_id' => 'nullable|integer',
        ], attributes: [
            'question' => 'pergunta',
            'answer' => 'resposta',
            'suggestion_id' => 'sugestão',
        ]);
        $data['model_id'] = $this->model->id;

        $created = $this->model->questions()->create($data);
        if ($created) {
            if ($this->suggestion_id) {
                Suggestion::find($this->suggestion_id)->increment('usages');
            }

            $temp_id_to_remove = $this->temp_id;

            $this->reset('question', 'answer', 'suggestion_id', 'temp_id');
            $this->toast()->success('Pergunta criada com sucesso.')->send();
            $this->dispatch('questionCreated');

            $this->setSuggestionProperties($temp_id_to_remove ?? null);
        }
    }

    public function removeSuggestion($temp_id)
    {
        $this->suggestions = array_filter($this->suggestions, function ($s) use ($temp_id) {
            return $s['temp_id'] !== $temp_id;
        });
        $this->suggestions = array_values($this->suggestions);

        if ($this->temp_id == $temp_id) {
            $temp_id_to_remove = $this->temp_id;
            $this->reset('question', 'answer', 'suggestion_id', 'temp_id');
            $this->setSuggestionProperties($temp_id_to_remove ?? null);
        }
    }
}
