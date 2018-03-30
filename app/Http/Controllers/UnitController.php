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
        $units = Unit::where(function ($query) use ($request) {
            if ($request->has('search')) {
                $search = trim($request->get('search'));
                $query->where('mac_address', 'LIKE', '%' . $search . '%');
            }
        })
            ->orderBy('created_at', 'desc')
            ->with(['patients'])
            ->paginate(5);
        return $units;
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'unit.mac_address'           => 'required',
            'unit.unit_is_active'        => 'required',
            'unit.oximeter_is_active'    => 'required',
            'unit.bp_is_active'          => 'required',
            'unit.thermometer_is_active' => 'required',
            'unit.oximeter_delay'        => 'required',
            'unit.bp_delay'              => 'required',
            'unit.thermometer_delay'     => 'required',
        ]);
        $createdUnit = Unit::create($request->get('unit'));

        return response()->json(['request' => $request->all(), 'unit' => $createdUnit]); 
    }
    public function get_store(Request $request)
    {
        $this->validate($request, [
            'mac_address'           => 'required',
            'unit_is_active'        => 'required',
            'oximeter_is_active'    => 'required',
            'bp_is_active'          => 'required',
            'thermometer_is_active' => 'required',
            'oximeter_delay'        => 'required',
            'bp_delay'              => 'required',
            'thermometer_delay'     => 'required',
        ]);
        $create = Unit::create($request->all());
        return response()->json(['status' => 'success', 'msg' => 'Unit created successfully']);
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
            'mac_address'           => 'required',
            'unit_is_active'        => 'required',
            'oximeter_is_active'    => 'required',
            'bp_is_active'          => 'required',
            'thermometer_is_active' => 'required',
            'oximeter_delay'        => 'required',
            'bp_delay'              => 'required',
            'thermometer_delay'     => 'required',
        ]);
        $unit = Unit::find($id);
        if ($unit->count()) {
            $unit->update($request->all());
            return response()->json(['statur' => 'success', 'msg' => 'Unit updated successfully']);
        } else {
            return response()->json(['statur' => 'error', 'msg' => 'error in updating unit']);
        }
    }
    public function destroy($id)
    {
        $unit = Unit::find($id);
        if ($unit->count()) {
            $unit->delete();
            return response()->json(['statur' => 'success', 'msg' => 'Unit deleted successfully']);
        } else {
            return response()->json(['statur' => 'error', 'msg' => 'error in deleting unit']);
        }
    }
}
