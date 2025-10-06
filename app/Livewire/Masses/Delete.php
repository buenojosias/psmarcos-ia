<?php

namespace App\Livewire\Masses;

use App\Models\Mass;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Delete extends Component
{
    use Interactions;

    public $massId;

    #[On('delete-mass')]
    public function deleteMass($mass)
    {
        $this->massId = $mass;
        $this->dialog()
            ->question('Deseja realmente excluir esta missa?')
            ->confirm(method: 'confirmed', params: 'Confirmed Successfully')
            ->cancel()
            ->send();
    }

    public function confirmed()
    {
        \DB::connection('pgsql')->table(config('database.table_vector'))
            ->where('resource', 'missa')
            ->where('model_id', $this->massId)
            ->delete();

        if (Mass::find($this->massId)->delete()) {
            $this->toast()->success('Missa excluída com sucesso!')->send();
            $this->dispatch('deleted');
        } else {
            $this->toast()->error('Erro ao excluir missa!')->send();
        }
    }

    public function render()
    {
        return view('livewire.masses.delete');
    }
}
