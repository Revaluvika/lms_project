<?php

namespace App\Enums;

enum MonthlyIncome: string
{
    case NO_INCOME = 'no_income';
    case LESS_THAN_1M = 'less_than_1m';
    case BETWEEN_1M_2M = '1m_to_2m';
    case BETWEEN_2M_5M = '2m_to_5m';
    case BETWEEN_5M_20M = '5m_to_20m';
    case MORE_THAN_20M = 'more_than_20m';

    public function label(): string
    {
        return match($this) {
            self::NO_INCOME => 'Tidak Berpenghasilan',
            self::LESS_THAN_1M => 'Kurang dari Rp 1.000.000',
            self::BETWEEN_1M_2M => 'Rp 1.000.000 - Rp 2.000.000',
            self::BETWEEN_2M_5M => 'Rp 2.000.000 - Rp 5.000.000',
            self::BETWEEN_5M_20M => 'Rp 5.000.000 - Rp 20.000.000',
            self::MORE_THAN_20M => 'Lebih dari Rp 20.000.000',
        };
    }
}
