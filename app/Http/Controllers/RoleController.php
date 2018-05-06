<?php
namespace App\Http\Controllers;
use App\Role;
use Illuminate\Http\Request;
class RoleController extends Controller
{
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
            ->paginate(100);
        return $role;
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'       => 'required'
        ]);
        $create = Role::create($request->all());
        return response()->json(['status' => 'success', 'msg' => 'role created successfully']);
    }
    public function show($id)
    {
        return Role::find($id);
    }
    public function edit($id)
    {
        return Role::find($id);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'       => 'required'
        ]);
        $role = Role::find($id);
        if ($role->count()) {
            $role->update($request->all());
            return response()->json(['statur' => 'success', 'msg' => 'Role updated successfully']);
        } else {
            return response()->json(['statur' => 'error', 'msg' => 'error in updating role']);
        }
    }
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
