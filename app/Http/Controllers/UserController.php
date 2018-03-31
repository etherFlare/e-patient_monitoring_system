<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        return view('user.index');
    }
    public function index(Request $request)
    {

        $user = User::where(function ($query) use ($request) {
            if ($request->has('search')) {
                $search = trim($request->get('search'));
                $query->where('first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('middle_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            }
        })

            ->orderBy('created_at', 'desc')
            ->with(['roles'])
            ->paginate(20);
        return $user;
    }
    public function store(Request $request)
    {

        $this->validate($request, [
            'user.email'          => 'required|unique:users,email',
            'user.password'       => 'required',
            'user.first_name'     => 'required',
            'user.middle_name'    => 'required',
            'user.last_name'      => 'required',
            'user.contact_number' => 'required',
        ]);

        $createdUser = User::create($request->get('user'));

        $createdUser->roles()->sync($request->get('user')['roles']);

        return response()->json(['request' => $request->all(), 'user' => $createdUser, 'status' => 'success', 'msg' => 'User created successfully' ]);

        // return response()->json(['status' => 'success', 'msg' => 'User created successfully']);
    }
  
    public function show($id)
    {
        return User::find($id);
    }
    public function edit($id)
    {
        return User::find($id);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user.email'          => 'required',
            'user.first_name'     => 'required',
            'user.middle_name'    => 'required',
            'user.last_name'      => 'required',
            'user.contact_number' => 'required',
        ]);
        $user = User::find($id);
        if ($user->count()) {
            $user->update($request->get('user'));

        $user->roles()->sync($request->get('user')['roles']);
             return response()->json(['request' => $request->all(), 'user' => $user, 'status' => 'success', 'msg' => 'User created successfully' ]);
            //return response()->json(['status' => 'success', 'msg' => 'User updated successfully']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'error in updating user ']);
        }
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->count()) {
            $user->delete();
            return response()->json(['status' => 'success', 'msg' => 'User deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'error in deleting user']);
        }
    }
}
