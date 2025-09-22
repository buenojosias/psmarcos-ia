<?php

namespace App\Livewire\Pastorals;

use App\Models\Pastoral;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $headers = [
            ['index' => 'pastoral_name', 'label' => 'Nome'],
            ['index' => 'community.name', 'label' => 'Comunidade'],
            ['index' => 'user.name', 'label' => 'Coordenador(a)'],
            // [ 'index' => 'Q&As', 'label' => 'Q&As'],
            ['index' => 'action'],
        ];

        $rows = Pastoral::orderBy('name')->with('community', 'user')->get();

        return view('livewire.pastorals.index', compact('headers', 'rows'))
            ->title('Grupos, movimentos e pastorais');
    }
}
