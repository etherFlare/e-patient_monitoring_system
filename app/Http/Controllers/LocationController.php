<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Location;
class LocationController extends Controller
{
	public function home(){
		return view('location.index');
	}
	public function index(Request $request)
	{
		$locations = Location::where(function($query) use($request) {
			if($request->has('search')){
				$search = trim($request->get('search'));
				$query->where('name', 'LIKE', '%'. $search .'%')->orWhere('description', 'LIKE', '%'. $search .'%');
			}
		})
		->orderBy('created_at', 'desc')
		->paginate($request->get('per_page', 100));
		return $locations;
	}
	public function create()
	{
	}
	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
		]);
		$create = Location::create($request->all());
		return response()->json(['status' => 'success','msg'=>'location created successfully']);
	}
	public function show($id)
	{
		return Location::find($id);
	}
	public function edit($id)
	{
		return Location::find($id);
	}
	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'name' => 'required',
		]);
		$location = Location::find($id);
		if($location->count()){
			$location->update($request->all());
			return response()->json(['status'=>'success','msg'=>'Location updated successfully']);
		} else {
			return response()->json(['status'=>'error','msg'=>'error in updating location']);
		}
	}
	public function destroy($id)
	{
		$location = Location::find($id);
		if($location->count()){
			$location->delete();
			return response()->json(['status'=>'success','msg'=>'Location deleted successfully']);
		} else {
			return response()->json(['status'=>'error','msg'=>'error in deleting location']);
		}
	}
}