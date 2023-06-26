<?php

namespace App\Http\Controllers\Data\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public function __construct(){

        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                return response('Unauthorized', 403);
            }
            return $next($request);
        })->only(['index', 'store', 'destroy']);


    }


    public function index()
{
    return User::latest()->paginate(10);
}

    public function store(StoreUserRequest $request){
        $user = User::create($request->only('name', 'email', 'password', 'role'));

    return response()->json([
        'message' => 'User created successfully',
        'user' => $user,
    ], 201);
        return $request->all();
    }

    public function destroy($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $user->delete();

    return response()->json(['message' => 'User deleted successfully'], 200);
}


    //Update
    public function update(Request $request, User $user)
{
    // Validate the input data if needed
    // ...

    // Update the user with the new data
    $user->update($request->all());

    return response()->json([
        'message' => 'User updated successfully',
        'user' => $user,
    ], 200);
}


}
