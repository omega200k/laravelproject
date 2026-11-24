<?php

namespace App\Support;

class Money
{
    public static function format(string|int|float|null $amount): string
    {
        return '₱'.number_format((float) $amount, 2);
    }
}
