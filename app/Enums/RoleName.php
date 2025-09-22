<?php

namespace App\Enums;

enum RoleName: string
{
    case SUPER_ADMIN = 'super admin';
    case DEV = 'dev';
    case TENANT_ADMIN = 'tenant admin';
    case TENANT_MEMBER = 'tenant member';
    case TENANT_GUEST= 'tenant guest';
}
