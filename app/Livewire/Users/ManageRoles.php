<?php

namespace App\Livewire\Users;

use App\Enums\UserRoleEnum;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class ManageRoles extends Component
{
    use Interactions;

    public $roles = [];
    public array $selectedRoles = [];
    public $user;

    public function mount($user)
    {
        $this->user = $user;
        $this->roles = UserRoleEnum::cases();
        // $this->selectedRoles = $user->roles;

        // normalize: garante que $raw será um array (não null)
        $raw = $user->roles;

        // se for Collection -> converte
        if ($raw instanceof \Illuminate\Support\Collection) {
            $raw = $raw->toArray();
        }

        // se for string JSON -> decode
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            $raw = $decoded === null ? [] : $decoded;
        }

        // forçar para array (transforma null em [])
        $raw = (array) $raw;

        // normaliza elementos (se vierem como objetos/enums/models)
        $this->selectedRoles = array_map(function ($r) {
            // enum object (BackedEnum)
            if (is_object($r) && property_exists($r, 'value')) {
                return (string) $r->value;
            }
            // se for modelo com atributo 'role' por exemplo:
            if (is_array($r) && array_key_exists('role', $r)) {
                return (string) $r['role'];
            }
            return (string) $r;
        }, $raw);
    }

    public function save()
    {
        $this->user->roles = $this->selectedRoles;
        if ($this->user->save()) {
            $this->toast()->success('Funções atualizadas com sucesso!')->send();
            $this->dispatch('saved');
        } else {
            $this->toast()->error('Erro ao atualizar funções.')->send();
        }
    }

    public function render()
    {
        return view('livewire.users.manage-roles');
    }
}
