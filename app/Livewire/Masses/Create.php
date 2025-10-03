<?php

namespace App\Livewire\Masses;

use App\Enums\WeekdayEnum;
use App\Models\Community;
use App\Models\Event;
use App\Models\Mass;
use App\Services\VectorizeMassService;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Interactions;

    public $community_id;
    public $weekday;
    public $time;
    public $note;

    public $communities = [];
    public $weekdays = [];

    public function mount()
    {
        $this->weekdays = [['value' => null, 'label' => 'Selecione um dia']];
        foreach (WeekdayEnum::cases() as $day) {
            $this->weekdays[] = [
                'value' => $day->value,
                'label' => $day->getLabel(),
            ];
        }
    }

    #[On('modalOpened')]
    public function loadCommunities()
    {
        if (!empty($this->communities)) {
            return;
        }
        $this->communities = Community::select(['id', 'name'])->get()->toArray();
        $this->communities = array_merge([['id' => null, 'name' => 'Selecione uma comunidade']], $this->communities);
    }

    public function render()
    {
        return view('livewire.masses.create');
    }

    public function save()
    {
        $data = $this->validate([
            'community_id' => 'required|exists:communities,id',
            'weekday' => 'required|in:' . implode(',', array_column(WeekdayEnum::cases(), 'value')),
            'time' => 'required|date_format:H:i',
            'note' => 'nullable|string|max:255',
        ]);

        $community_name = $this->communities[$this->community_id]['name'] ?? null;
        $data['name'] = "Missa na {$community_name}, " . strtolower(WeekdayEnum::from($this->weekday)->getLabel()) . " às {$this->time}." . ($this->note ? " ({$this->note})" : '');

        \DB::beginTransaction();
        $mass = Mass::create($data);
        $vectored = VectorizeMassService::vectorizeMassData($mass);

        if ($mass && $vectored) {
            \DB::commit();
            $this->dispatch('saved')->self();
            $this->toast()->success('Missa adicionada com sucesso.')->send();
            $this->reset(['weekday', 'time', 'note']);
        } else {
            \DB::rollBack();
            $this->toast()->error('Erro ao adicionar a missa.')->send();
            return;
        }
    }
}
