<?php

namespace App\Enums;

enum RelationType: string
{
    case BIOLOGICAL_FATHER = 'biological_father';
    case BIOLOGICAL_MOTHER = 'biological_mother';
    case GUARDIAN = 'guardian';

    public function label(): string
    {
        return match($this) {
            self::BIOLOGICAL_FATHER => 'Ayah Kandung',
            self::BIOLOGICAL_MOTHER => 'Ibu Kandung',
            self::GUARDIAN => 'Wali',
        };
    }
}
