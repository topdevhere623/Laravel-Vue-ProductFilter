<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;

class UsersController extends Controller
{

    public function index()
    {
        return QueryBuilder::for(User::class)->get();
    }


    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $attributes = $request->validated();
        $user->update( Arr::except($attributes, ['patient']));

        if ($request->has('patient')) {
            $user->patient->update(Arr::only($request->get('patient'), 'goal'));
        }

        return $user;
    }

    public function destroy($id)
    {
        //
    }

    ///
    ///
    public function auth(Request $request)
    {
        $user = $request->user();
        if ($user->hasRole('patient')) {
            $user->load('patient');
        }
        $user->roles = $user->roles()->pluck('name');
        return ['data' => $user];
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $password_confirmation = $request->password_confirmation;
        $userId = $request->userId;

        $user = User::find($userId);

        if (Hash::check($old_password, $user->password)) {
            $user->password = Hash::make($new_password);
            $user->save();
            return response()->json(['success' => true ]);
        }
        else {
            return response()->json(['success' => false ]);
        }
    }
}
