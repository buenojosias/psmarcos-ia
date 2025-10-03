<?php

namespace App\Enums;

enum WeekdayEnum: int
{
    case DOM = 1;
    case SEG = 2;
    case TER = 3;
    case QUA = 4;
    case QUI = 5;
    case SEX = 6;
    case SAB = 7;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel()
    {
        return match ($this) {
            self::DOM => 'Domingo',
            self::SEG => 'Segunda-feira',
            self::TER => 'Terça-feira',
            self::QUA => 'Quarta-feira',
            self::QUI => 'Quinta-feira',
            self::SEX => 'Sexta-feira',
            self::SAB => 'Sábado',
        };
    }
}
