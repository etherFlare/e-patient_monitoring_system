<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
/**
 * Display a listing of the resource.
 *
 * @return IlluminateHttpResponse
 */

    public function home()
    {
        return view('role.index');
    }

    public function index(Request $request)
    {

        $role = Role::where(function ($query) use ($request) {

            if ($request->has('search')) {
                $search = trim($request->get('search'));
                $query->where('title', 'LIKE', '%' . $search . '%')->orWhere('description', 'LIKE', '%' . $search . '%');
            }

        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $role;
    }

/**
 * Show the form for creating a new resource.
 *
 * @return IlluminateHttpResponse
 */
    public function create()
    {
//
    }

/**
 * Store a newly created resource in storage.
 *
 * @param  IlluminateHttpRequest  $request
 * @return IlluminateHttpResponse
 */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'       => 'required',
            'description' => 'required',
        ]);

        $create = Role::create($request->all());
        return response()->json(['status' => 'success', 'msg' => 'role created successfully']);
    }
    
    public function get_store(Request $request)
    {
        $this->validate($request, [
            'title'       => 'required',
            'description' => 'required',
        ]);

        $create = Role::create($request->all());
        return response()->json(['status' => 'success', 'msg' => 'role created successfully']);
    }

/**
 * Display the specified resource.
 *
 * @param  int  $id
 * @return IlluminateHttpResponse
 */
    public function show($id)
    {
        return Role::find($id);
    }

/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @return IlluminateHttpResponse
 */
    public function edit($id)
    {
        return Role::find($id);
    }

/**
 * Update the specified resource in storage.
 *
 * @param  IlluminateHttpRequest  $request
 * @param  int  $id
 * @return IlluminateHttpResponse
 */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'       => 'required',
            'description' => 'required',
        ]);

        $role = Role::find($id);
        if ($role->count()) {
            $role->update($request->all());
            return response()->json(['statur' => 'success', 'msg' => 'Role updated successfully']);
        } else {
            return response()->json(['statur' => 'error', 'msg' => 'error in updating role']);
        }
    }

/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return IlluminateHttpResponse
 */
    public function destroy($id)
    {
        $role = Role::find($id);
        if ($role->count()) {
            $role->delete();
            return response()->json(['statur' => 'success', 'msg' => 'Role deleted successfully']);
        } else {
            return response()->json(['statur' => 'error', 'msg' => 'error in deleting role']);
        }
    }
}
