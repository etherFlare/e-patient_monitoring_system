<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
class PatientController extends Controller
{
	public function home(){
		return view('patient.index');
	}
	public function index(Request $request)
	{
		$patient = Patient::where(function($query) use($request) {
			if($request->has('search')){
				$search = trim($request->get('search'));
				$query->where('first_name', 'LIKE', '%'. $search .'%');
			}
		})
		->orderBy('created_at', 'desc')
		->paginate(10);
		return $patient;
	}
	public function store(Request $request)
	{
		$this->validate($request, [
			'unit_id' => 'required',
			'first_name' => 'required',
			'middle_name' => 'required',
			'last_name' => 'required',
			'gender' => 'required',
			'age' => 'required',
			'location' => 'required',
			'home_address' => 'required',
			'contact_number' => 'required',
			'contact_person' => 'required',
			'is_active' => 'required',
			'is_archive' => 'required',
			'comment' => 'required',
		]);
		$create = Patient::create($request->all());
		return response()->json(['status' => 'success','msg'=>'Patient created successfully']);
	}
	public function get_store(Request $request)
	{
		$this->validate($request, [
			'unit_id' => 'required',
			'first_name' => 'required',
			'middle_name' => 'required',
			'last_name' => 'required',
			'gender' => 'required',
			'age' => 'required',
			'location' => 'required',
			'home_address' => 'required',
			'contact_number' => 'required',
			'contact_person' => 'required',
			'is_active' => 'required',
			'is_archive' => 'required',
			'comment' => 'required',
		]);
		$create = Patient::create($request->all());
		return response()->json(['status' => 'success','msg'=>'Patient created successfully']);
	}
	public function show($id)
	{
		return Patient::find($id);
	}
	public function edit($id)
	{
		return Patient::find($id);
	}
	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'unit_id' => 'required',
			'first_name' => 'required',
			'middle_name' => 'required',
			'last_name' => 'required',
			'gender' => 'required',
			'age' => 'required',
			'location' => 'required',
			'home_address' => 'required',
			'contact_number' => 'required',
			'contact_person' => 'required',
			'is_active' => 'required',
			'is_archive' => 'required',
			'comment' => 'required',
		]);
		$patient = Patient::find($id);
		if($patient->count()){
			$patient->update($request->all());
			return response()->json(['statur'=>'success','msg'=>'Patient updated successfully']);
		} else {
			return response()->json(['statur'=>'error','msg'=>'error in updating post']);
		}
	}
	public function destroy($id)
	{
		$patient = Patient::find($id);
		if($patient->count()){
			$patient->delete();
			return response()->json(['statur'=>'success','msg'=>'Patient deleted successfully']);
		} else {
			return response()->json(['statur'=>'error','msg'=>'error in deleting post']);
		}
	}
}
