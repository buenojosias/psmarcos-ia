<?php

namespace App\Livewire\Pastorals;

use App\Services\GeneratePastoralQuestions;
use Livewire\Component;

class GenerateQuestionSuggestions extends Component
{
    public $pastoral;
    public $questions = [];
    public $suggestions = [];

    public function mount($pastoral)
    {
        $this->pastoral = $pastoral;
    }

    public function render()
    {
        return view('livewire.pastorals.generate-question-suggestions');
    }

    public function generateQuestions()
    {
        // $this->suggestions = [
        //     0 => "Quais são os requisitos para participar do Coral Doce Canto?",
        //     1 => "O Coral Doce Canto realiza apresentações em eventos da paróquia?",
        //     2 => "Existe algum custo para participar do Coral Doce Canto?",
        //     3 => "Como posso me inscrever para o Coral Doce Canto?",
        //     4 => "O Coral Doce Canto aceita novos membros durante todo o ano?",
        //     5 => "Quais são os compromissos de ensaio do Coral Doce Canto?",
        //     6 => "O Coral Doce Canto tem alguma atividade especial durante o ano, como festivais ou concertos?",
        //     7 => "Há alguma preparação específica que os membros do Coral Doce Canto devem fazer antes das apresentações?",
        // ];
        // return;

        // verificar se suggestions já foram geradas
        if (!empty($this->suggestions)) {
            return;
        }

        $this->questions = $this->pastoral->questions->toArray();

        $generatedSuggestions = GeneratePastoralQuestions::generate($this->questions, $this->pastoral->name);
        if ($generatedSuggestions) {
            $content = $generatedSuggestions['choices'][0]['message']['content'] ?? [];
            $lines = explode("\n", $content);

            // Remover o traço e espaços iniciais de cada linha
            $this->suggestions = array_filter(array_map(function ($line) {
                // Ignora linhas vazias
                $clean = trim($line);
                return $clean ? ltrim($clean, "- \t") : null;
            }, $lines));
        } else {
            $this->suggestions = [];
        }
    }

    public function addSuggestion($index)
    {
        $suggestion = $this->suggestions[$index] ?? null;
        if ($suggestion) {
            $this->dispatch('addSuggestion', $suggestion);
            $this->removeSuggestion($index);
        }
    }

    public function removeSuggestion($index)
    {
        unset($this->suggestions[$index]);
        $this->suggestions = array_values($this->suggestions);
    }
}
