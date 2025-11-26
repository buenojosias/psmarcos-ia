<?php

namespace App\Enums;

enum ModelEnum: string
{
    case COMMUNITY = 'community';
    case PASTORAL = 'pastoral';
    case SERVICE = 'service';
    case EVENT = 'event';

    public function getLabel(): string
    {
        return match($this) {
            self::COMMUNITY => 'comunidade',
            self::PASTORAL => 'pastoral',
            self::SERVICE => 'serviço',
            self::EVENT => 'evento',
        };
    }

    public function getPluralLabel(): string
    {
        return match($this) {
            self::COMMUNITY => 'comunidades',
            self::PASTORAL => 'pastorais',
            self::SERVICE => 'serviços',
            self::EVENT => 'eventos',
        };
    }

    public function getWithArticleLabel(): string
    {
        return match($this) {
            self::COMMUNITY => 'a comunidade',
            self::PASTORAL => 'a pastoral',
            self::SERVICE => 'o serviço',
            self::EVENT => 'o evento',
        };
    }

    public function getWithPrepositionLabel(): string
    {
        return match($this) {
            self::COMMUNITY => 'da comunidade',
            self::PASTORAL => 'da pastoral',
            self::SERVICE => 'do serviço',
            self::EVENT => 'do evento',
        };
    }
}
