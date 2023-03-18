<?php

namespace App\Enums;

enum InstallSteps: int
{
    case START = 0;
    case REQUIREMENTS = 1;
    case DATABASE = 2;

    case MAIL = 3;
    case ADMINUSER = 4;

}
