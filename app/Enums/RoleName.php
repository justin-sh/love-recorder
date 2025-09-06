<?php

namespace App\Enums;

enum RoleName: string
{
    case ADMIN = 'admin';
    case DEV = 'dev';
    case GROUP_ADMIN = 'group admin';
    case GROUP_MEMBER = 'group member';
    case GROUP_GUEST= 'group guest';
}
