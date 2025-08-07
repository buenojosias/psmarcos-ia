<?php

namespace App\Enums;

enum QuestionStatusEnum: string
{
    case PENDING = 'pending';
    case PROCESSED = 'processed';
    case REJECTED = 'rejected';

    public function getLabel(): string
    {
        return match($this) {
            self::PENDING => 'Aguardando processamento',
            self::PROCESSED => 'Processada',
            self::REJECTED => 'Descartada',
        };
    }

    public function getIcon(): string
    {
        return match($this) {
            self::PENDING => 'clock',
            self::PROCESSED => 'check-circle',
            self::REJECTED => 'x-circle',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::PENDING => 'orange',
            self::PROCESSED => 'green',
            self::REJECTED => 'red',
        };
    }
}
