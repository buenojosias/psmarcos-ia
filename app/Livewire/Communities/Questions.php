<?php

namespace App\Livewire\Communities;

use App\Models\Community;
use App\Models\Pastoral;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Questions extends Component
{
    public $communityId;

    public function mount($community)
    {
        $this->communityId = $community;
    }

    #[Computed('community')]
    public function getCommunityProperty()
    {
        return Community::findOrFail($this->communityId);
    }

    public function render()
    {
        return view('livewire.communities.questions')
            ->title('Perguntas e respostas');
    }
}
