<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;


class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(UserResource::collection(User::all()));
    }

    public function store(UserRequest $request): JsonResponse
    {
        try {
            $user = new User;
            $user->fill($request->validated());
            $user->password = Hash::make($user->password);
            $user->role()
                ->associate(Role::where('name',env('ROLE_NAME_UNVERIFIED'))
                ->first());
            if ($user->save()){
                return response()->json(new UserResource($user));
            }
        } catch(Throwable $exception) {
            abort(400, $exception->getMessage());
        }
        return response()->json(null,400);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json(new UserResource($user));
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $user->update($request->all());
        return response()->json(new UserResource($user));
    }

    public function destroy(User $user): JsonResponse
    {
        try {
            $user->delete();
        } catch (Throwable $e) {
            abort(400, $e->getMessage());
        }
        return response()->json(['message' => 'User deleted'], 204);
    }

}
