<?php

namespace App\Livewire\Questions;

use App\Enums\SuggestionTypeEnum;
use App\Services\EnumService;
use Livewire\Component;

class SlideFilter extends Component
{
    public bool $onlyUnprocessed = false;
    public ?string $questionable = null;

    public array $questionableTypes = [];

    public function mount()
    {
        // $this->questionableTypes = [
        //     ['value' => null, 'label' => 'Todos'],
        //     ['value' => 'pastoral', 'label' => 'Pastorais'],
        //     ['value' => 'community', 'label' => 'Comunidades'],
        //     ['value' => 'event', 'label' => 'Eventos'],
        // ];
        $this->questionableTypes = EnumService::getOptionsFromEnum(SuggestionTypeEnum::class, 'Todos');
    }

    public function render()
    {
        return view('livewire.questions.slide-filter');
    }

    public function submit()
    {
        $this->dispatch('filterUpdated', [
            'onlyUnprocessed' => $this->onlyUnprocessed,
            'questionable' => $this->questionable,
        ]);
        $this->dispatch('slideClose')->self();
    }
}
