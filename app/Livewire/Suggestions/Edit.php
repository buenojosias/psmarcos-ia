<?php

namespace App\Livewire\Suggestions;

use App\Models\Suggestion;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Edit extends Component
{
    use Interactions;

    public $suggestion;
    public ?string $type = null;
    public ?string $content = null;

    #[On('edit-suggestion')]
    public function editSuggestion(Suggestion $suggestion)
    {
        $this->suggestion = $suggestion;
        $this->type = $suggestion->type->value;
        $this->content = $suggestion->content;

        $this->dispatch('open-modal');
    }

    public function save()
    {
        $data = $this->validate([
            'type' => 'required|string|max:1',
            'content' => 'required|string|max:255',
        ], attributes: [
            'type' => 'tipo',
            'content' => 'conteúdo',
        ]);

        if (!str_contains($data['content'], '##')) {
            $this->addError('content', 'O conteúdo deve conter "##" (sem aspas).');
            return;
        }

        if ($this->suggestion->update($data)) {
            $this->toast()->success('Sugestão atualizada com sucesso!')->send();
            $this->dispatch('saved');
            $this->reset(['type', 'content']);
        } else {
            $this->toast()->error('Erro ao atualizar sugestão. Tente novamente.')->send();
        }
    }

    public function render()
    {
        return view('livewire.suggestions.edit');
    }
}
