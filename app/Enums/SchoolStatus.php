<?php

namespace App\Enums;

enum SchoolStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case REJECTED = 'rejected';
    case SUSPENDED = 'suspended';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::ACTIVE => 'Active',
            self::REJECTED => 'Rejected',
            self::SUSPENDED => 'Suspended',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'bg-yellow-100 text-yellow-800',
            self::ACTIVE => 'bg-green-100 text-green-800',
            self::REJECTED => 'bg-red-100 text-red-800',
            self::SUSPENDED => 'bg-gray-100 text-gray-800',
        };
    }

    public function values(): array
    {
        return [
            self::PENDING->value,
            self::ACTIVE->value,
            self::REJECTED->value,
            self::SUSPENDED->value,
        ];
    }
}
