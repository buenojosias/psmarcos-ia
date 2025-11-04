<?php

namespace App\Enums;

enum SuggestionTypeEnum: string
{
    case COMMUNITY = 'C';
    case PASTORAL = 'P';
    case EVENT = 'E';
    case GENERAL = 'G';

    public function getLabel(): string
    {
        return match ($this) {
            self::COMMUNITY => 'Comunidade',
            self::PASTORAL => 'Grupo, movimento ou pastoral',
            self::EVENT => 'Evento',
            self::GENERAL => 'Geral',
        };
    }
}
