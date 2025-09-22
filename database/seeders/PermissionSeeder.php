<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = [
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
        ];

        $resources = [
            'child',
            'event',
            'tenant'
        ];

        collect($resources)
            ->crossJoin($actions)
            ->map(function ($set) {
                return implode('.', $set);
            })->each(function ($permission) {
                Permission::findOrCreate($permission);
            });
    }
}
