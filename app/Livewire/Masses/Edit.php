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

class Edit extends Component
{
    use Interactions;

    public $mass;
    public $community_id;
    public $community_name;
    public $weekday;
    public $time;
    public $note;

    #[On('edit-mass')]
    public function editMass(Mass $mass)
    {
        $this->authorize('edit', $mass);

        $this->mass = $mass;
        $this->community_id = $mass->community_id;
        $this->community_name = $mass->community->name;
        $this->weekday = $mass->weekday->getLabel();
        $this->time = $mass->time->format('H:i');
        $this->note = $mass->note;

        $this->dispatch('open-modal');
    }

    // public function loadCommunities()
    // {
    //     if (!empty($this->communities)) {
    //         return;
    //     }
    //     $this->communities = Community::query()
    //         ->select(['id', 'name'])
    //         ->when(!auth()->user()->hasAnyRole(['admin', 'pascom']), function ($query) {
    //             $query->whereHas('leaders', function ($q) {
    //                 $q->where('user_id', auth()->id());
    //             });
    //         })
    //         ->get()
    //         ->toArray();

    //     if (!auth()->user()->hasAnyRole(['admin', 'pascom']) && empty($this->communities)) {
    //         abort(403, 'Você não tem permissão para adicionar missas.');
    //     }

    //     $this->communities = array_merge([['id' => null, 'name' => 'Selecione uma comunidade']], $this->communities);
    // }

    public function render()
    {
        return view('livewire.masses.edit');
    }

    public function save()
    {
        if ($this->note == '') { $this->note = null; }
        $data = $this->validate([
            'time' => 'required|date_format:H:i',
            'note' => 'nullable|string|max:255',
        ], attributes: [
            'time' => 'horário',
            'note' => 'observação',
        ]);

        // $community_name = $this->communities[$this->community_id]['name'] ?? null;
        $data['name'] = "Missa - {$this->community_name} - {$this->weekday} - {$this->time}";

        if ($this->mass->update($data)) {
            \DB::connection('pgsql')->table(config('database.table_vector'))
                ->where('resource', 'missa')
                ->where('doc_type', 'mass_data')
                ->where('model_id', $this->mass->id)
                ->delete();

            $vectored = VectorizeMassService::vectorizeMassData($this->mass);
        }

        if ($vectored) {
            $this->dispatch('saved')->self();
            $this->toast()->success('Missa editada com sucesso.')->send();
            $this->reset();
        } else {
            $this->toast()->error('Erro ao editar a missa.')->send();
            return;
        }
    }
}
