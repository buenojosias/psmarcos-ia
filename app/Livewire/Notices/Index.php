<?php

namespace App\Livewire\Notices;

use App\Models\Notice;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Computed('notices')]
    public function getNoticesProperty()
    {
        $notices = Notice::query()
            ->with('notifiable')
            ->orderBy('expires_at', 'asc')
            ->get();

        $notices->map(function ($notice) {
            $notice->formatted_expires_at = Carbon::parse($notice->expires_at)->format('d/m/Y');
            return $notice;
        });

        return $notices;
    }

    public function render()
    {
        $headers = [
            ['index' => 'notice_content', 'label' => 'Aviso'],
            ['index' => 'notifiable.name', 'label' => 'Vinculado a'],
            ['index' => 'formatted_expires_at', 'label' => 'Expira em'],
            ['index' => 'action'],
        ];

        $rows = $this->notices;

        return view('livewire.notices.index', compact('headers', 'rows'))
            ->title('Avisos');
    }
}
