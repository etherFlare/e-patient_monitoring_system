<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UnitPatientMetadataPatientMetadata;
class MetadataController extends Controller
{
    public function home(){
		return view('metadata.index');
	}
	public function index(Request $request)
	{
		$metadata = UnitPatientMetadata::where(function($query) use($request) {
			if($request->has('search')){
				$search = trim($request->get('search')); 
				$query->where('uniy_id', 'LIKE', '%'. $search .'%');
			}
		})
		->orderBy('created_at', 'desc')
		->paginate(10);
		return $metadata;
	}
	public function store(Request $request)
	{
		$this->validate($request, [
			'uniy_id' => 'required',
			'sensor_type' => 'required',
			'sensor_value' => 'required',
		]);
		$create = UnitPatientMetadata::create($request->all());
		return response()->json(['status' => 'success','msg'=>'UnitPatientMetadata created successfully']);
	}
	public function get_store(Request $request)
	{
		$this->validate($request, [
			'uniy_id' => 'required',
			'sensor_type' => 'required',
			'sensor_value' => 'required',
		]);
		$create = UnitPatientMetadata::create($request->all());
		return response()->json(['status' => 'success','msg'=>'UnitPatientMetadata created successfully']);
	}
	public function show($id)
	{
		return UnitPatientMetadata::find($id);
	}
	public function edit($id)
	{
		return UnitPatientMetadata::find($id);
	}
	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'uniy_id' => 'required',
			'sensor_type' => 'required',
			'sensor_value' => 'required',
		]);
		$metadata = UnitPatientMetadata::find($id);
		if($metadata->count()){
			$metadata->update($request->all());
			return response()->json(['statur'=>'success','msg'=>'UnitPatientMetadata updated successfully']);
		} else {
			return response()->json(['statur'=>'error','msg'=>'error in updating post']);
		}
	}
	public function destroy($id)
	{
		$metadata = UnitPatientMetadata::find($id);
		if($metadata->count()){
			$metadata->delete();
			return response()->json(['statur'=>'success','msg'=>'UnitPatientMetadata deleted successfully']);
		} else {
			return response()->json(['statur'=>'error','msg'=>'error in deleting post']);
		}
	}
}
