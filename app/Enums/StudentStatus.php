<?php

namespace App\Enums;

enum StudentStatus: string
{
    case ACTIVE = 'active';
    case TRANSFERRED = 'transferred';
    case GRADUATED = 'graduated';
    case DROPPED_OUT = 'dropped_out';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Aktif',
            self::TRANSFERRED => 'Pindah',
            self::GRADUATED => 'Lulus',
            self::DROPPED_OUT => 'Drop Out',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'bg-green-100 text-green-800',
            self::TRANSFERRED => 'bg-yellow-100 text-yellow-800',
            self::GRADUATED => 'bg-blue-100 text-blue-800',
            self::DROPPED_OUT => 'bg-red-100 text-red-800',
        };
    }
}
