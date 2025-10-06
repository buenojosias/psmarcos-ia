<?php

namespace App\Livewire\Notices;

use App\Models\Notice;
use App\Services\VectorizeNoticeService;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Interactions;

    public $resource;
    public $model;
    public $content;
    public $expires_at;

    public function mount($resource, $model = null)
    {
        $this->resource = $resource;
        $this->model = $model;
    }

    public function save()
    {
        $data = $this->validate([
            'content' => 'required|string|max:255',
            'expires_at' => 'nullable|date|after:date',
        ]);

        \DB::beginTransaction();
        $notice = $this->model->notices()->create($data);
        $vectored = VectorizeNoticeService::vectorizeNoticeData($this->resource, $notice);

        if ($notice && $vectored) {
            \DB::commit();
            $this->dispatch('saved')->self();
            $this->toast()->success('Aviso adicionado com sucesso.')->send();
            $this->reset(['content', 'expires_at']);
        } else {
            \DB::rollBack();
            $this->toast()->error('Erro ao adicionar o aviso.')->send();
            return;
        }
    }

    public function render()
    {
        return view('livewire.notices.create');
    }
}
