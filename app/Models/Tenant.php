<?php

namespace App\Models;

use Illuminate\Support\Str;

class Tenant
{
    private function __construct(private readonly string $id = '')
    {
    }

    static Tenant $current;

    public static function setId($id): void
    {
        static::$current = new Tenant($id);
    }

    public static function getId(): ?string
    {
        return static::$current?->id;
    }

    public static function getRawId(): ?int
    {
        return intval(Str::substr(Str::trim(static::$current?->id), Str::length(config('app.tenant.prefix'))));
    }
}
