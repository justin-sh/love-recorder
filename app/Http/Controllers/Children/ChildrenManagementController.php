<?php

namespace App\Http\Controllers\Children;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChildResource;
use App\Models\Child;
use App\Models\TenantHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ChildrenManagementController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'gender' => 'required'
        ]);

        $child = new Child();

        $child->name = $validatedData['name'];
        $child->gender = $validatedData['gender'];
        $child->birthday = $request->date('birthday');
        $child->height_dob = $request->integer('height');
        $child->weight_dob = $request->integer('weight');
        $child->user_id = $request->user()->id;
        $child->save();

        return to_route('children.list', TenantHelper::getPrefixId());
    }

    public function list(Request $request): Response
    {
        ChildResource::withoutWrapping();

        /** @var User $user */
        $user = $request->user();

        $children = Child::query()
            ->where('tenant_id', TenantHelper::getRawId())
            ->whereIn('tenant_id', $user->tenants()->pluck('tenants.id'))
            ->get();

        $data = ChildResource::collection($children);
        return Inertia::render('children/List', [
            'children' => $data,
        ]);
    }
}
