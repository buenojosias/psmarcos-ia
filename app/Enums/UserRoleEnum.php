<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case COORDINATOR = 'coordinator';
    case SECRETARY = 'secretary';
    case PASCOM = 'pascom';
    case PRIEST = 'priest';
    case ADMIN = 'admin';

    public function getLabel(): string
    {
        return match ($this) {
            self::COORDINATOR => 'Coordenador(a) de pastoral',
            self::SECRETARY => 'Secretário(a)',
            self::PASCOM => 'Pasconeiro(a)',
            self::PRIEST => 'Padre',
            self::ADMIN => 'Administrador',
        };
    }
}
