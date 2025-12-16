<?php

namespace App\Enums;

enum PromotionStatus: string
{
    case PROMOTED = 'promoted';
    case RETAINED = 'retained';
    case GRADUATED = 'graduated';
    case CONTINUING = 'continuing';

    public function label(): string
    {
        return match($this) {
            self::PROMOTED => 'Naik Kelas',
            self::RETAINED => 'Tinggal Kelas',
            self::GRADUATED => 'Lulus',
            self::CONTINUING => 'Masih Berlanjut',
        };
    }
}
