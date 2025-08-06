<?php

namespace App\Livewire\Pastorals;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.pastorals.index')
            ->title('Grupos, movimentos e pastorais');
    }
}
