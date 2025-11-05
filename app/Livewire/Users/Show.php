<?php

namespace App\Livewire\Users;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public $user;
    public $roles = [];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->user->load('communities', 'pastorals.community');
        $this->roles = UserRoleEnum::cases();
    }

    public function render()
    {
        return view('livewire.users.show')
            ->title('Usuário');
    }
}
