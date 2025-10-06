<?php

namespace App\Livewire\Questions;

use App\Models\Suggestion;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class DefaultSuggestions extends Component
{
    use Interactions;

    public $resource;
    public $type;
    public $model;
    public $suggestions = [];

    public function mount($model, $resource)
    {
        $this->model = $model;
        $this->resource = $resource;
        $this->type = \Str::upper(substr($resource, 0, 1));
    }

    public function render()
    {
        return view('livewire.questions.default-suggestions');
    }

    public function loadSuggestions()
    {
        // verificar se suggestions já foram geradas
        if (!empty($this->suggestions)) {
            return;
        }

        $suggestions = Suggestion::query()
            ->where('type', $this->type)
            ->whereDoesntHave('questions', function ($query) {
                $query->where('questionable_type', $this->resource)
                    ->where('questionable_id', $this->model->id);
            })
            ->get();

        $suggestions->map(function ($suggestion) {
            $suggestion->content = str_replace('##', $this->model->name, $suggestion->content);
            return $suggestion;
        });

        $this->suggestions = $suggestions->toArray();
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
