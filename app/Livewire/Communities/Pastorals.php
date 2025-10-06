<?php

namespace App\Livewire\Communities;

use App\Models\Community;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Pastorals extends Component
{
    public $community;

    public function mount(Community $community)
    {
        $this->community = $community;
    }

    #[Computed('pastorals')]
    public function getPastoralsProperty()
    {
        return $this->community->pastorals()->with('user')->orderBy('name')->get();
    }

    public function render()
    {
        $headers = [
            ['index' => 'pastoral_name', 'label' => 'Nome'],
            ['index' => 'user.name', 'label' => 'Coordenador(a)'],
            ['index' => 'action'],
        ];

        $rows = $this->pastorals;

        return view('livewire.communities.pastorals', compact('headers', 'rows'))
            ->title('Grupos, movimentos e pastorais da');
    }
}
