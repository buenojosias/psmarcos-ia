<?php

namespace App\Livewire\Pastorals;

use App\Models\Pastoral;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Index extends Component
{
    #[Computed('pastorals')]
    public function getPastoralsProperty()
    {
        $pastorals = Pastoral::orderBy('name')->with('community', 'leaders')->get();

        $pastorals->map(function ($pastoral) {
            $pastoral->coordinator = $pastoral->leaders->first() ?? null;

            return $pastoral;
        });

        return $pastorals;
    }



    public function render()
    {
        $headers = [
            ['index' => 'pastoral_name', 'label' => 'Nome'],
            ['index' => 'community.name', 'label' => 'Comunidade'],
            ['index' => 'coordinator.name', 'label' => 'Coordenador(a)'],
            ['index' => 'action'],
        ];

        $rows = $this->pastorals;

        return view('livewire.pastorals.index', compact('headers', 'rows'))
            ->title('Grupos, movimentos e pastorais');
    }
}
