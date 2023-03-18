<?php

namespace App\Exceptions;

use Exception;

class UploadFailed extends Exception
{
    public static function uuidInUse()
    {
        return new static('This UUID is already used.');
    }
}
