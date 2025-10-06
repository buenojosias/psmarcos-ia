<?php

namespace App\Livewire\Questions;

use App\Models\Question;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?int $quantity = 10;
    public ?string $search = null;
    public ?string $questionable = null;
    public ?array $selected = [];

    #[Computed('questions')]
    public function getQuestionsProperty()
    {
        $questions = Question::query()
            ->when($this->search, function (Builder $query) {
                return $query->whereAny(['question', 'answer'], 'like', "%{$this->search}%");
            })
            ->when($this->questionable, function (Builder $query) {
                return $query->where('questionable_type', '=', \Str::singular(ucfirst($this->questionable)));
            })
            ->with('questionable')
            ->paginate($this->quantity)
            ->withQueryString();

        $questions->map(function ($question) {
            return $question->route_name = \Str::plural($question->questionable_type);
        });

        return $questions;
    }

    public function render()
    {
        $headers = [
            ['index' => 'qa', 'label' => 'Pergunta e resposta'],
            ['index' => 'v', 'label' => 'Vinculado a'],
            ['index' => 'action'],
        ];

        $rows = $this->questions;

        return view('livewire.questions.index', compact('headers', 'rows'))
            ->title('Perguntas e respostas');
    }
}
