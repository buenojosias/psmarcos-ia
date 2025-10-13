<?php

namespace App\Livewire\Masses;

use App\Models\Mass;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Index extends Component
{
    #[Computed('masses')]
    public function getMassesProperty()
    {
        $masses = Mass::query()
            ->with('community')
            // ->whereIn('weekday', [1, 7])
            ->orderBy('weekday', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        $masses->map(function ($mass) {
            $mass->weekday_label = $mass->weekday ? $mass->weekday->getLabel() : null;
            $mass->formatted_time = $mass->time ? $mass->time->format('H\hi') : null;
            $mass->formatted_time = str_replace('00', '', $mass->formatted_time);
            return $mass;
        });

        return $masses;
    }

    public function render()
    {
        $headers = [
            ['index' => 'weekday_label', 'label' => 'Dia da semana'],
            ['index' => 'formatted_time', 'label' => 'Hora'],
            ['index' => 'community.name', 'label' => 'Comunidade'],
            ['index' => 'note'],
            ['index' => 'action'],
        ];

        $rows = $this->masses;

        return view('livewire.masses.index', compact('headers', 'rows'))
            ->title('Missas');
    }
}
