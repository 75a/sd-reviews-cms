<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;


class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function store(UserRequest $request)
    {
        try {

            $user = new User;
            $user->fill($request->validated());
            $user->password = Hash::make($user->password);
            $user->role()->associate(Role::where('name',env('ROLE_NAME_UNVERIFIED'))->first());

            if ($user->save()){
                return new UserResource($user);
            }
        } catch(\Exception $exception) {

            abort(400, $exception->getMessage());

        }
        return null;
    }

    public function show(User $user)
    {
        return response()->json($user);
       //return response()->json(['message' => 'User not found'], 404);
    }
}
