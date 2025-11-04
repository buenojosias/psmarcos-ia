<?php

namespace App\Services;

class EnumService
{
    public static function getOptionsFromEnum(string $enumClass, string $emptyLabel = null): array
    {
        $options = [];
        if ($emptyLabel) {
            $options[] = ['value' => '', 'label' => $emptyLabel];
        }
        foreach ($enumClass::cases() as $case) {
            $options[] = [
                'value' => $case->value,
                'label' => method_exists($case, 'getLabel') ? $case->getLabel() : $case->name,
            ];
        }

        return $options;
    }
}
