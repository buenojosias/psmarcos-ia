<?php

namespace App\Livewire\Communities;

use App\Models\Community;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    #[Computed]
    public function getCommunitiesProperty()
    {
        return Community::all();
    }

    public function render()
    {
        return view('livewire.communities.index')
            ->title('Comunidades');
    }
}
