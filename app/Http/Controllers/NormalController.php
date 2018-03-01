<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NormalReference;
class NormalController extends Controller
{
    public function home(){
		return view('normal.index');
	}
	public function index(Request $request)
	{
		$normal = NormalReference::where(function($query) use($request) {
			if($request->has('search')){
				$search = trim($request->get('search')); 
				$query->where('type', 'LIKE', '%'. $search .'%');
			}
		})
		->orderBy('created_at', 'desc')
		->paginate(10);
		return $normal;
	}
	public function store(Request $request)
	{
		$this->validate($request, [
					'type' => 'required',
		'upper_limit' => 'required',
		'lower_limit' => 'required'
		]);
		$create = NormalReference::create($request->all());
		return response()->json(['status' => 'success','msg'=>'NormalReference created successfully']);
	}
	public function get_store(Request $request)
	{
		$this->validate($request, [
								'type' => 'required',
		'upper_limit' => 'required',
		'lower_limit' => 'required'
		]);
		$create = NormalReference::create($request->all());
		return response()->json(['status' => 'success','msg'=>'NormalReference created successfully']);
	}
	public function show($id)
	{
		return NormalReference::find($id);
	}
	public function edit($id)
	{
		return NormalReference::find($id);
	}
	public function update(Request $request, $id)
	{
		$this->validate($request, [
					'type' => 'required',
		'upper_limit' => 'required',
		'lower_limit' => 'required'
		]);
		$normal = NormalReference::find($id);
		if($normal->count()){
			$normal->update($request->all());
			return response()->json(['statur'=>'success','msg'=>'NormalReference updated successfully']);
		} else {
			return response()->json(['statur'=>'error','msg'=>'error in updating post']);
		}
	}
	public function destroy($id)
	{
		$normal = NormalReference::find($id);
		if($normal->count()){
			$normal->delete();
			return response()->json(['statur'=>'success','msg'=>'NormalReference deleted successfully']);
		} else {
			return response()->json(['statur'=>'error','msg'=>'error in deleting post']);
		}
	}
}
