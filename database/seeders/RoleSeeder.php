<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createDevRole();
        $this->createAdminRole();
        $this->createGroupAminRole();
        $this->createGroupMemberRole();
        $this->createGroupGuestRole();
    }

    private function createRole(RoleName $role, Collection $permissions): void
    {
        $newRole = Role::findOrCreate($role->value);
        $newRole->permissions()->sync($permissions);
    }

    private function createDevRole(): void
    {
        $permissions = Permission::query()
            ->whereLike('name', 'child.%')
            ->orWhereLike('name', 'event.%')
            ->orWhereLike('name', 'tenant.%')
            ->pluck('id');

        $this->createRole(RoleName::DEV, $permissions);
    }

    private function createAdminRole(): void
    {
        $permissions = Permission::query()
            ->whereLike('name', 'child.%')
            ->orWhereLike('name', 'event.%')
            ->orWhereLike('name', 'tenant.%')
            ->pluck('id');

        $this->createRole(RoleName::SUPER_ADMIN, $permissions);
    }

    private function createGroupAminRole(): void
    {
        $permissions = Permission::query()
            ->whereLike('name', 'child.%')
            ->orWhereLike('name', 'event.%')
            ->orWhere(function (Builder $query) {
                $query->whereLike('name', 'tenant.%')
                    ->whereNot('name', 'tenant.viewAny');
            })
            ->pluck('id');

        $this->createRole(RoleName::TENANT_ADMIN, $permissions);
    }

    private function createGroupMemberRole(): void
    {
        $permissions = Permission::query()
            ->whereLike('name', 'child.%')
            ->orWhereLike('name', 'event.%')
            ->orWhereIn('name', ['tenant.view', 'tenant.update'])
            ->pluck('id');

        $this->createRole(RoleName::TENANT_MEMBER, $permissions);
    }

    private function createGroupGuestRole(): void
    {
        $permissions = Permission::query()
            ->whereLike('name', 'child.view%')
            ->orWhereLike('name', 'event.view%')
            ->where('name', 'tenant.view')
            ->pluck('id');

        $this->createRole(RoleName::TENANT_GUEST, $permissions);
    }
}
