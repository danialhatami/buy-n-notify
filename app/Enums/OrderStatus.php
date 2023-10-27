<?php

namespace App\Enums;

enum OrderStatus: string {
    case CREATED = 'CREATED';
    case PAID = 'PAID';
    case EXPIRED = 'EXPIRED';

    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $enum) {
            $values[] = $enum->value;
        }
        return $values;
    }
}
