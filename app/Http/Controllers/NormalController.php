<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NormalReference;
class NormalController extends Controller
{
	 public function print(Request $request){
        $normals = NormalReference::where(function($query) use($request) {
			if($request->has('search')){
				$search = trim($request->get('search')); 
				$query->where('type_id', 'LIKE', '%'. $search .'%');
			}
		})
		->orderBy('created_at', 'desc')
		->with(['type'])
        ->with(['patient'])
		->paginate();
        return view('normal.print', compact('normals'));
    }
    public function home(){
		return view('normal.index');
	}
	public function index(Request $request)
	{
		$normals = NormalReference::where(function($query) use($request) {
			if($request->has('search')){
				$search = trim($request->get('search')); 
				$query->where('type_id', 'LIKE', '%'. $search .'%');
			}
		})
		->orderBy('created_at', 'desc')
		->with(['type'])
        ->with(['patient'])
		->paginate(10);
		return $normals;
	}
	public function store(Request $request)
	{
		$this->validate($request, [
		'normal.type_id'	 => 'required',
		'normal.patient_id'  => 'required',
		'normal.upper_limit' => 'required',
		'normal.lower_limit' => 'required'
		]);
		$createdNormal = NormalReference::create($request->get('normal'));
        return response()->json(['request' => $request->all(), 'normal' => $createdNormal, 'status' => 'success', 'msg' => 'normal refernce updated successfully']);
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
		'normal.type_id' 	 => 'required',
		'normal.patient_id'  => 'required',
		'normal.upper_limit' => 'required',
		'normal.lower_limit' => 'required'
		]);
		$normal = NormalReference::find($id);
		if($normal->count()){
			$normal->update($request->get('normal'));
			return response()->json(['request' => $request->all(), 'normal' => $normal, 'status' => 'success', 'msg' => 'normal refernce updated successfully']);
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
