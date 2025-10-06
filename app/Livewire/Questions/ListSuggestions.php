<?php

namespace App\Livewire\Questions;

use App\Models\Suggestion;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ListSuggestions extends Component
{
    use WithPagination;

    public ?int $quantity = 10;
    public ?string $type = null;
    public ?array $selected = [];

    #[Computed('suggestions')]
    public function getSuggestionsProperty()
    {
        $suggestions = Suggestion::query()
            ->when($this->type, function ($query) {
                return $query->where('type', $this->type);
            })
            ->paginate($this->quantity)
            ->withQueryString();

        return $suggestions;
    }

    public function render()
    {
        $headers = [
            ['index' => 'content', 'label' => 'Pergunta sugerida'],
            ['index' => 'type', 'label' => 'Tipo'],
            ['index' => 'usages', 'label' => 'Usos'],
            ['index' => 'action'],
        ];

        $rows = $this->suggestions;

        return view('livewire.questions.list-suggestions', compact('headers', 'rows'))
            ->title('Sugestões de perguntas');
    }
}
