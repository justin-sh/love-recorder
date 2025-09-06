<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

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
        $newRole = Role::create(['name' => $role->value]);
        $newRole->permissions()->sync($permissions);
    }

    private function createDevRole(): void
    {
        $permissions = Permission::query()
            ->whereLike('name', 'child.%')
            ->orWhereLike('name', 'event.%')
            ->orWhereLike('name', 'group.%')
            ->pluck('id');

        $this->createRole(RoleName::DEV, $permissions);
    }

    private function createAdminRole(): void
    {
        $permissions = Permission::query()
            ->whereLike('name', 'child.%')
            ->orWhereLike('name', 'event.%')
            ->orWhereLike('name', 'group.%')
            ->pluck('id');

        $this->createRole(RoleName::ADMIN, $permissions);
    }

    private function createGroupAminRole(): void
    {
        $permissions = Permission::query()
            ->whereLike('name', 'child.%')
            ->orWhereLike('name', 'event.%')
            ->orWhere(function (Builder $query) {
                $query->whereLike('name', 'group.%')
                    ->whereNot('name', 'group.viewAny');
            })
            ->pluck('id');

        $this->createRole(RoleName::GROUP_ADMIN, $permissions);
    }

    private function createGroupMemberRole(): void
    {
        $permissions = Permission::query()
            ->whereLike('name', 'child.%')
            ->orWhereLike('name', 'event.%')
            ->orWhereIn('name', ['group.view', 'group.update'])
            ->pluck('id');

        $this->createRole(RoleName::GROUP_MEMBER, $permissions);
    }

    private function createGroupGuestRole(): void
    {
        $permissions = Permission::query()
            ->whereLike('name', 'child.view%')
            ->orWhereLike('name', 'event.view%')
            ->where('name', 'group.view')
            ->pluck('id');

        $this->createRole(RoleName::GROUP_GUEST, $permissions);
    }
}
