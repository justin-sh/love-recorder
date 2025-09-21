<?php

namespace App\Models;

use Illuminate\Support\Str;

class TenantHelper
{
    public static function getRawId(): ?int
    {
        return getPermissionsTeamId();
    }

    public static function getPrefixId(): string
    {
        $tenantId = getPermissionsTeamId();
        $prefix = config('app.tenant.prefix');

        return $prefix . $tenantId;
    }

    public static function setId(string $tenantId): void
    {
        $prefix = config('app.tenant.prefix');
        $tenantId = Str::trim($tenantId);
        if (Str::startsWith($tenantId, $prefix)) {
            $tenantId = Str::substr($tenantId, Str::length($prefix));
        }
        setPermissionsTeamId(intval($tenantId));
    }
}
