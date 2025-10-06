<?php

namespace App\Livewire\Notices;

use Livewire\Attributes\Computed;
use Livewire\Component;

class ListNotices extends Component
{
    public $resource;
    public $model;

    public function mount($resource, $model)
    {
        $this->resource = $resource;
        $this->model = $model;
    }

    #[Computed('notices')]
    public function getNoticesProperty()
    {
        return $this->model->notices;
    }

    public function render()
    {
        return view('livewire.notices.list-notices');
    }
}
