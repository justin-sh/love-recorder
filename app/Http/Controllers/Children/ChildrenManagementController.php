<?php

namespace App\Http\Controllers\Children;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChildResource;
use App\Models\Child;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ChildrenManagementController extends Controller
{
    public function create(Request $request): RedirectResponse
    {
//        return Inertia::render('children/Add', [
//            'canResetPassword' => Route::has('password.request'),
//            'status' => $request->session()->get('status'),
//        ]);
        $validatedData = $request->validate([
            'name'=>'required|max:255',
            'gender'=>'required'
        ]);

        Log::debug(json_encode($validatedData));
        $child = new Child($validatedData);
        $child->name = $validatedData['name'];
        $child->gender = $validatedData['gender'];
        $child->birthday = $request->date('birthday');
        $child->height_dob = $request->integer('height');
        $child->weight_dob = $request->integer('weight');
        $child->save();

        return to_route('children.list');
    }

    public function list(Request $request): Response
    {
        ChildResource::withoutWrapping();;
        $data = ChildResource::collection(Child::all());
        return Inertia::render('children/List', [
            'children'=> $data,
        ]);
    }
}
