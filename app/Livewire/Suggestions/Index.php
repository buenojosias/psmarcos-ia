<?php

namespace App\Livewire\Suggestions;

use App\Enums\SuggestionTypeEnum;
use App\Models\Suggestion;
use App\Services\EnumService;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?int $quantity = 10;
    public ?string $type = null;

    #[Computed('suggestions')]
    public function getSuggestionsProperty()
    {
        $suggestions = Suggestion::query()
            ->when($this->type, function ($query) {
                return $query->where('type', $this->type);
            })
            ->paginate($this->quantity)
            ->withQueryString();

        $suggestions->map(function ($suggestion) {
            $suggestion->type_label = $suggestion->type->getLabel();
            return $suggestion;
        });

        return $suggestions;
    }

    public function render()
    {
        $types = EnumService::getOptionsFromEnum(SuggestionTypeEnum::class, 'Todos');
        $headers = [
            ['index' => 'content', 'label' => 'Pergunta sugerida'],
            ['index' => 'type_label', 'label' => 'Tipo'],
            ['index' => 'usages', 'label' => 'Usos'],
            ['index' => 'action'],
        ];

        $rows = $this->suggestions;

        return view('livewire.suggestions.index', compact('headers', 'rows', 'types'))
            ->title('Sugestões de perguntas');
    }
}
