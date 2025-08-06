<?php

namespace App\Livewire\Communities;

use App\Models\Community;
use Livewire\Component;

class Show extends Component
{
    public $community;

    public function mount(Community $community)
    {
        $this->community = $community;
    }

    public function render()
    {
        return view('livewire.communities.show')
            ->title($this->community->name);
    }
}
