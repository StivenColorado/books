<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class userController extends Controller
{

    public function index(Request $request)
    {
        $users = User::get();
        if (!$request->ajax()) return view();
        return response()->json(['users' => $users], 200);
    }
    public function create()
    {
        //view
    }


    public function store(UserRequest $request)
    {
        // User::create(['number_id'=>$request->number_id]);
        $user = new User($request->all());
        $user->save();
        if (!$request->ajax()) return back()->with('succes', 'User Created');
        return response()->json(['status' => 'User Created'], 201);
    }


    public function show(Request $request, User $user)
    {
        if (!$request->ajax()) return view();
        return response()->json(['user' => $user], 200);
    }

    public function edit(User $user)
    {
        //
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        if (!$request->ajax()) return back()->with('succes', 'User update');
        return response()->json([], 204);
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();
        if (!$request->ajax()) return back()->with('Succes', 'User deleted');
        return response()->json([], 204);
    }
}
