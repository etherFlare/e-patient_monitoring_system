<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Type;
class TypeController extends Controller
{
    public function home(){
		return view('type.index');
	}
	public function index(Request $request)
	{
		$types = Type::where(function($query) use($request) {
			if($request->has('search')){
				$search = trim($request->get('search'));
				$query->where('name', 'LIKE', '%'. $search .'%')->orWhere('description', 'LIKE', '%'. $search .'%');
			}
		})
		->orderBy('created_at', 'desc')
		->paginate($request->get('per_page', 10));
		return $types;
	}
	public function create()
	{
	}
	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
		]);
		$create = Type::create($request->all());
		return response()->json(['status' => 'success','msg'=>'type created successfully']);
	}
	public function show($id)
	{
		return Type::find($id);
	}
	public function edit($id)
	{
		return Type::find($id);
	}
	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'name' => 'required',
		]);
		$type = Type::find($id);
		if($type->count()){
			$type->update($request->all());
			return response()->json(['status'=>'success','msg'=>'Type updated successfully']);
		} else {
			return response()->json(['status'=>'error','msg'=>'error in updating type']);
		}
	}
	public function destroy($id)
	{
		$type = Type::find($id);
		if($type->count()){
			$type->delete();
			return response()->json(['status'=>'success','msg'=>'Type deleted successfully']);
		} else {
			return response()->json(['status'=>'error','msg'=>'error in deleting type']);
		}
	}
}
