<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case COORDINATOR = 'coordinator';
    case SECRETARY = 'secretary';
    case PASCOM = 'pascom';
    case ADMIN = 'admin';

    public function getLabel(): string
    {
        return match ($this) {
            self::COORDINATOR => 'Coordenador/membro de pastoral',
            self::SECRETARY => 'Secretário(a)',
            self::PASCOM => 'Pasconeiro(a)',
            self::ADMIN => 'Administrador',
        };
    }
}
