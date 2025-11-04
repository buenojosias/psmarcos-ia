<?php

namespace App\Livewire\Suggestions;

use App\Models\Suggestion;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Delete extends Component
{
    use Interactions;

    public $suggestionId;
    public $suggestion;

    #[On('delete-suggestion')]
    public function deletesuggestion($suggestion)
    {
        $this->suggestionId = $suggestion;
        $this->suggestion = Suggestion::find($suggestion);
        $this->dialog()
            ->question('Deseja realmente excluir esta sugestão de pergunta?')
            ->confirm(method: 'confirmed', params: $this->suggestionId)
            ->cancel()
            ->send();
    }

    public function confirmed()
    {
        if ($this->suggestion->delete()) {
            $this->toast()->success('Sugestão excluída com sucesso!')->send();
            $this->dispatch('deleted');
        } else {
            $this->toast()->error('Erro ao excluir sugestão!')->send();
        }
    }

    public function render()
    {
        return view('livewire.suggestions.delete');
    }
}
