<?php

namespace App\Livewire\Questions;

use App\Services\GenerateAiQuestions;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class GenerateSuggestions extends Component
{
    use Interactions;

    public $resource;
    public $model;
    public $questions = [];
    public $suggestions = [];

    public function mount($model, $resource)
    {
        $this->model = $model;
        $this->resource = $resource;
    }

    public function render()
    {
        return view('livewire.questions.generate-suggestions');
    }

    public function generateQuestions()
    {
        // verificar se suggestions já foram geradas
        if (!empty($this->suggestions)) {
            return;
        }

        $this->questions = $this->model->questions->toArray();

        $generatedSuggestions = GenerateAiQuestions::generate($this->resource, $this->model->name, $this->model->description, $this->questions);
        if ($generatedSuggestions) {
            $content = $generatedSuggestions['choices'][0]['message']['content'] ?? [];
            $lines = explode("\n", $content);

            // Remover o traço e espaços iniciais de cada linha
            $this->suggestions = array_filter(array_map(function ($line) {
                // Ignora linhas vazias
                $clean = trim($line);
                return $clean ? ltrim($clean, "- \t") : null;
            }, $lines));
        } else {
            $this->suggestions = [];
            $this->dispatch('closeModal')->self();
            $this->toast()->error('Não foi possível gerar sugestões', 'Adicione uma descrição ou algumas perguntas e tente novamente.')->send();
        }
    }

    public function addSuggestion($index)
    {
        $suggestion = $this->suggestions[$index] ?? null;
        if ($suggestion) {
            $this->dispatch('addSuggestion', $suggestion);
            $this->removeSuggestion($index);
        }
    }

    public function removeSuggestion($index)
    {
        unset($this->suggestions[$index]);
        $this->suggestions = array_values($this->suggestions);
    }
}
