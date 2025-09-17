<?php

namespace App\Models;

class Tenant
{
    private function __construct(private readonly string $id = "")
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
}
