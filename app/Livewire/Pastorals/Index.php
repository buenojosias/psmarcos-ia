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
            ['index' => 'users.0.name', 'label' => 'Coordenador(a)'],
            ['index' => 'action'],
        ];

        $rows = Pastoral::orderBy('name')->with(['community', 'users' => fn($query) => $query->wherePivot('is_leader', true)->first()])->get();

        return view('livewire.pastorals.index', compact('headers', 'rows'))
            ->title('Grupos, movimentos e pastorais');
    }
}
