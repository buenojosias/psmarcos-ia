<?php

namespace App\Livewire\Suggestions;

use App\Models\Suggestion;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Interactions;

    public ?string $type = null;
    public ?string $content = null;

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

        if (Suggestion::create($data)) {
            $this->toast()->success('Sugestão criada com sucesso!')->send();
            $this->dispatch('saved');
            $this->reset(['type', 'content']);
        } else {
            $this->toast()->error('Erro ao criar sugestão. Tente novamente.')->send();
        }
    }

    public function render()
    {
        return view('livewire.suggestions.create');
    }
}
