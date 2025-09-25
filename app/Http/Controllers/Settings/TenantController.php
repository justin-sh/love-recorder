<?php

namespace App\Http\Controllers\Settings;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use App\Models\TenantHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class TenantController extends Controller
{
    /**
     * Show the tenant's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/Tenant', [
            'tenant' => new TenantResource($request->user()->tenant()),
            'role' => [['v' => RoleName::TENANT_MEMBER->value, 'label' => RoleName::TENANT_MEMBER->displayName()],
                ['v' => RoleName::TENANT_GUEST->value, 'label' => RoleName::TENANT_GUEST->displayName()]],
        ]);
    }

    /**
     * Update the tenant's profile information.
     */
    public function update(Request $request)
    {
//        Log::info('|||' . $request->string('role') . '||||');
        $role = RoleName::from($request->string('role'));
        $name = $request->string('name');
        $email = $request->string('email');
//        Log::info($role->name . $name . $email);

        if(empty($name)){
            return json_encode(['ok' => false, 'error' => ['target' => 'name', 'msg' => 'Name can not be empty.']]);
        }

        $invitedUser = User::query()->where('email', $email)->first();
        if ($invitedUser == null) {
            return json_encode(['ok' => false, 'error' => ['target' => 'email', 'msg' => 'No user found. Please check email.']]);
        }

        /** @var User $user */
        $user = $request->user();
        $tenant = $user->tenant();
        $invitedUser->tenants()->attach(TenantHelper::getRawId(), ['tenant_role' => $role->value]);

        if ($name != $tenant->name) {
            $tenant->name = $name;
            $tenant->save();
        }

        return json_encode(['ok' => true]);
    }
}
