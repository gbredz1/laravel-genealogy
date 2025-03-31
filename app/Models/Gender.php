<?php

namespace App\Models;

enum Gender: string
{
    case Male = 'male';
    case Female = 'female';
    case Other = 'other';
    case NotSpecified = 'not_specified';

    /**
     * Get all the values as an array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all the cases as an array for select options
     */
    public static function options(): array
    {
        return [
            self::Male->value,
            self::Female->value,
            self::Other->value,
            self::NotSpecified->value,
        ];
    }
}
