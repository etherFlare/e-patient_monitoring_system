<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
   public function home(){
		return view('user.index');
	}
	public function index(Request $request)
	{
		$user = User::where(function($query) use($request) {
			if($request->has('search')){
				$search = trim($request->get('search')); 
				$query->where('name', 'LIKE', '%'. $search .'%');
			}
		})
		->orderBy('created_at', 'desc')
		->paginate(10);
		return $user;
	}
	public function store(Request $request)
	{
		$this->validate($request, [
			'email' => 'required',
			'password' => 'required',
			'first_name' => 'required',
			'middle_name' => 'required',
			'last_name' => 'required',
			'contact_number' => 'required',
			'is_archive' => 'required',
		]);
		$create = User::create($request->all());
		return response()->json(['status' => 'success','msg'=>'User created successfully']);
	}
	public function get_store(Request $request)
	{
		$this->validate($request, [
			'email' => 'required',
			'password' => 'required',
			'first_name' => 'required',
			'middle_name' => 'required',
			'last_name' => 'required',
			'contact_number' => 'required',
			'is_archive' => 'required'
		]);
		$create = User::create($request->all());
		return response()->json(['status' => 'success','msg'=>'User created successfully']);
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
			'email' => 'required',
			'password' => 'required',
			'first_name' => 'required',
			'middle_name' => 'required',
			'last_name' => 'required',
			'contact_number' => 'required',
			'is_archive' => 'required',
		]);
		$user = User::find($id);
		if($user->count()){
			$user->update($request->all());
			return response()->json(['statur'=>'success','msg'=>'User updated successfully']);
		} else {
			return response()->json(['statur'=>'error','msg'=>'error in updating post']);
		}
	}
	public function destroy($id)
	{
		$user = User::find($id);
		if($user->count()){
			$user->delete();
			return response()->json(['statur'=>'success','msg'=>'User deleted successfully']);
		} else {
			return response()->json(['statur'=>'error','msg'=>'error in deleting post']);
		}
	}
}
