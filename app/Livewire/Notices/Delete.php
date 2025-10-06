<?php

namespace App\Livewire\Notices;

use App\Models\Notice;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Delete extends Component
{
    use Interactions;

    public $noticeId;

    #[On('delete-notice')]
    public function deletenotice($notice)
    {
        $this->noticeId = $notice;
        $this->dialog()
            ->question('Deseja realmente excluir este aviso?')
            ->confirm(method: 'confirmed', params: 'Confirmed Successfully')
            ->cancel()
            ->send();
    }

    public function confirmed()
    {
        \DB::connection('pgsql')->table('documents')
            ->where('resource', 'aviso')
            ->where('model_id', $this->noticeId)
            ->delete();

        if (Notice::find($this->noticeId)->delete()) {
            $this->toast()->success('Aviso excluído com sucesso!')->send();
            $this->dispatch('deleted');
        } else {
            $this->toast()->error('Erro ao excluir aviso!')->send();
        }
    }

    public function render()
    {
        return view('livewire.notices.delete');
    }
}
