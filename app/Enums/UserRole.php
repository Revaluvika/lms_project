<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPERADMIN = 'superadmin';
    case KEPALA_SEKOLAH = 'kepala_sekolah';
    case GURU = 'guru';
    case SISWA = 'siswa';
    case ORANG_TUA = 'orang_tua';
    case DINAS = 'dinas';
    case ADMIN_SEKOLAH = 'admin_sekolah';
    case ADMIN_DINAS = 'admin_dinas';

    public function values(): array
    {
        return [
            self::SUPERADMIN->value,
            self::KEPALA_SEKOLAH->value,
            self::GURU->value,
            self::SISWA->value,
            self::ORANG_TUA->value,
            self::DINAS->value,
            self::ADMIN_SEKOLAH->value,
            self::ADMIN_DINAS->value,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::SUPERADMIN => 'Superadmin',
            self::KEPALA_SEKOLAH => 'Kepala Sekolah',
            self::GURU => 'Guru',
            self::SISWA => 'Siswa',
            self::ORANG_TUA => 'Orang Tua',
            self::DINAS => 'Dinas',
            self::ADMIN_SEKOLAH => 'Admin Sekolah',
            self::ADMIN_DINAS => 'Admin Dinas',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SUPERADMIN => 'bg-blue-100 text-blue-800',
            self::KEPALA_SEKOLAH => 'bg-green-100 text-green-800',
            self::GURU => 'bg-yellow-100 text-yellow-800',
            self::SISWA => 'bg-red-100 text-red-800',
            self::ORANG_TUA => 'bg-purple-100 text-purple-800',
            self::DINAS => 'bg-pink-100 text-pink-800',
            self::ADMIN_SEKOLAH => 'bg-indigo-100 text-indigo-800',
            self::ADMIN_DINAS => 'bg-orange-100 text-orange-800',
        };
    }
}
