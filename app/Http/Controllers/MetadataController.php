<?php
namespace App\Http\Controllers;

use App\UnitPatientMetadata;
use Illuminate\Http\Request;

class MetadataController extends Controller
{
    public function home()
    {
        return view('metadata.index');
    }
    public function create_meta(Request $request)
    {
    	// return $request->all();
        $this->validate($request, [
            'meta.unit_id'      => 'required',
            'meta.sensor_type'  => 'required',
            'meta.sensor_value' => 'required',
            'meta.mac'          => 'required',
        ]);
        $meta = UnitPatientMetadata::create($request->get('meta'));
        return $meta;
    }
    public function index(Request $request)
    {
        if ($request->has('meta') && $request->has('action') && $request->get('action') === "add") {
            return self::create_meta($request);
        }
        if ($request->has('meta') && $request->has('action') && $request->get('action') === "getting") {
        	return self::get_update($request);		
        }
        $metadata = UnitPatientMetadata::where(function ($query) use ($request) {
            if ($request->has('search')) {
                $search = trim($request->get('search'));
                $query->where('mac', 'LIKE', '%' . $search . '%');
            }
        })
            ->orderBy('created_at', 'desc')
            ->paginate(100);
        return $metadata;
    }
    public public function get_update(Request $request){

    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'unit_id'      => 'required',
            'sensor_type'  => 'required',
            'sensor_value' => 'required',
        ]);
        $create = UnitPatientMetadata::create($request->all());
        return response()->json(['status' => 'success', 'msg' => 'UnitPatientMetadata created successfully']);
    }
    public function show($id)
    {
        return UnitPatientMetadata::find($id);
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
    }
    public function destroy($id)
    {
    }
}
