<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Unit;
class UnitController extends Controller
{
    public function home(){
        return view('unit.index');
    }
    public function index(Request $request)
    {
        $units = Unit::where(function($query) use($request) {
            if($request->has('search')){
                $search = trim($request->get('search')); 
                $query->where('mac_address', 'LIKE', '%'. $search .'%');
            }
        })
        ->orderBy('created_at', 'desc')
        ->paginate(5);
        return $units;
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'mac_address' => 'required',
            'unit_is_active' => 'required',
            'oximeter_is_active' => 'required',
            'bp_is_active' => 'required',
            'thermometer_is_active' => 'required',
            'oximeter_delay' => 'required',
            'bp_delay' => 'required',
            'thermometer_delay' => 'required'
        ]);
        $create = Unit::create($request->all());
        return response()->json(['status' => 'success','msg'=>'Unit created successfully']);
    }
    public function get_store(Request $request)
    {
        $this->validate($request, [
            'mac_address' => 'required',
            'unit_is_active' => 'required',
            'oximeter_is_active' => 'required',
            'bp_is_active' => 'required',
            'thermometer_is_active' => 'required',
            'oximeter_delay' => 'required',
            'bp_delay' => 'required',
            'thermometer_delay' => 'required',
        ]);
        $create = Unit::create($request->all());
        return response()->json(['status' => 'success','msg'=>'Unit created successfully']);
    }
    public function show($id)
    {
        return Unit::find($id);
    }
    public function edit($id)
    {
        return Unit::find($id);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'mac_address' => 'required',
            'unit_is_active' => 'required',
            'oximeter_is_active' => 'required',
            'bp_is_active' => 'required',
            'thermometer_is_active' => 'required',
            'oximeter_delay' => 'required',
            'bp_delay' => 'required',
            'thermometer_delay' => 'required',
        ]);
        $unit = Unit::find($id);
        if($unit->count()){
            $unit->update($request->all());
            return response()->json(['statur'=>'success','msg'=>'Unit updated successfully']);
        } else {
            return response()->json(['statur'=>'error','msg'=>'error in updating unit']);
        }
    }
    public function destroy($id)
    {
        $unit = Unit::find($id);
        if($unit->count()){
            $unit->delete();
            return response()->json(['statur'=>'success','msg'=>'Unit deleted successfully']);
        } else {
            return response()->json(['statur'=>'error','msg'=>'error in deleting unit']);
        }
    }
}
