<?php

namespace App\Livewire\Users;

use Livewire\Component;

class Pastorals extends Component
{
    public $user;
    public $pastorals = [];
    public $communities = [];

    public function mount($user)
    {
        $this->user = $user;
        $this->pastorals = $this->user->pastorals;
        $this->communities = $this->user->communities;
    }

    public function render()
    {
        return view('livewire.users.pastorals');
    }
}
