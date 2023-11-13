<?php

namespace App\Classes;

class UniqueNumberGenerator
{
    public static function generate($length = 6): string
    {
        return substr(number_format(time() * rand(), 0, '', ''), 0, $length);
    }

}
