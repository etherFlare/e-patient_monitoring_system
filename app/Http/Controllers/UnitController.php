<?php
namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function home()
    {
        return view('unit.index');
    }
    public function index(Request $request)
    {
        if ($request->has('meta') && $request->has('action') && $request->get('action') === "getting") {
            return self::get_update($request);      
        }
        $units = Unit::where(function ($query) use ($request) {
            if ($request->has('search')) {
                $search = trim($request->get('search'));
                $query->where('mac_address', 'LIKE', '%' . $search . '%');
            }
        })
            ->orderBy('created_at', 'desc')
            ->with(['patients'])
            ->paginate(10);
        return $units;
    }
     public function get_update(Request $request){
       $unit = Unit::find($request->get('id'));
       return response()->json(['Request' => $unit,'status' => 'success', 'msg' => 'UnitPatientMetadata created successfully']);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'unit.mac_address'           => 'required',
            'unit.label'                 => 'required',
            'unit.unit_is_active'        => 'required',
            'unit.oximeter_is_active'    => 'required',
            'unit.bp_is_active'          => 'required',
            'unit.thermometer_is_active' => 'required',
            'unit.oximeter_delay'        => 'required',
            'unit.bp_delay'              => 'required',
            'unit.thermometer_delay'     => 'required',
        ]);
        $createdUnit = Unit::create($request->get('unit'));

        return response()->json(['request' => $request->all(), 'unit' => $createdUnit, 'status' => 'success', 'msg' => 'Unit created successfully']); 
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
            'unit.mac_address'           => 'required',
            'unit.label'                 => 'required',
            'unit.unit_is_active'        => 'required',
            'unit.oximeter_is_active'    => 'required',
            'unit.bp_is_active'          => 'required',
            'unit.thermometer_is_active' => 'required',
            'unit.oximeter_delay'        => 'required',
            'unit.bp_delay'              => 'required',
            'unit.thermometer_delay'     => 'required',
        ]);
        $unit = Unit::find($id);
        if ($unit->count()) {
            $unit->update($request->get('unit'));
            return response()->json(['request' => $request->all(), 'unit' => $unit, 'status' => 'success', 'msg' => 'Unit created successfully']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'error in updating unit']);
        }
    }
    public function destroy($id)
    {
        $unit = Unit::find($id);
        if ($unit->count()) {
            $unit->delete();
            return response()->json(['status' => 'success', 'msg' => 'Unit deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'error in deleting unit']);
        }
    }
}
