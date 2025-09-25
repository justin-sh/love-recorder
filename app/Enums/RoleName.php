<?php

namespace App\Enums;

enum RoleName: string
{
    case SUPER_ADMIN = 'super admin';
    case DEV = 'dev';
    case TENANT_ADMIN = 'tenant admin';
    case TENANT_MEMBER = 'tenant member';
    case TENANT_GUEST = 'tenant guest';

    public function displayName(): string
    {
        return match ($this) {
            RoleName::TENANT_ADMIN => "Team Admin",
            RoleName::TENANT_MEMBER => "Team Member",
            RoleName::TENANT_GUEST => "Team Guest",
            default => "Guest",
        };
    }
}
