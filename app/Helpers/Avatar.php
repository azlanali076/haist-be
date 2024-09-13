<?php
namespace App\Helpers;

class Avatar {

    public static function generateAvatar(string $fullName, $background = 'random', $size = '256'): string
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($fullName).'&background='.$background.'&size='.$size;
    }

}
