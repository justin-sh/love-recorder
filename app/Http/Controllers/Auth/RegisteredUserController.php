<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Role;
use App\Models\TenantHelper;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $defaultTeam = new Tenant(['name' => $user->name . '\'s default group']);
        $defaultTeam->save();

        $user->default_tenant_id = $defaultTeam->id;
        $user->save();

        $user->tenants()->attach($defaultTeam);

        TenantHelper::setId($defaultTeam->id);

        $user->assignRole(RoleName::TENANT_ADMIN->value);

        event(new Registered($user));

        Auth::login($user);

        return to_route('dashboard', TenantHelper::getPrefixId());
    }
}
