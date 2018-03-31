<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function home()
    {
        return view('patient.index');
    }
    public function index(Request $request)
    {
        $patients = Patient::where(function ($query) use ($request) {
            if ($request->has('search')) {
                $search = trim($request->get('search'));
                $query->where('first_name', 'LIKE', '%' . $search . '%');
            }
        })
            ->orderBy('created_at', 'desc')
            ->with(['location'])
            ->with(['unit'])
            ->paginate(10);
        return $patients;
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            //'patient.location_id'    => 'required',
            'patient.unit_id'        => 'required',
            'patient.first_name'     => 'required',
            'patient.middle_name'    => 'required',
            'patient.last_name'      => 'required',
            'patient.gender'         => 'required',
            'patient.age'            => 'required',
            //'patient.location'       => 'required',
            'patient.home_address'   => 'required',
            'patient.contact_number' => 'required',
            'patient.contact_person' => 'required',
            'patient.comment'        => 'required',
        ]);
        $createdPatient = Patient::create($request->get('patient'));
        return response()->json(['request' => $request->all(), 'patient' => $createdPatient, 'statur' => 'success', 'msg' => 'Patient updated successfully']);
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
            'unit_id'        => 'required',
            'first_name'     => 'required',
            'middle_name'    => 'required',
            'last_name'      => 'required',
            'gender'         => 'required',
            'age'            => 'required',
            'home_address'   => 'required',
            'contact_number' => 'required',
            'contact_person' => 'required',
            'is_active'      => 'required',
            'is_archive'     => 'required',
            'comment'        => 'required',
        ]);
        $patient = Patient::find($id);
        if ($patient->count()) {
            $patient->update($request->all());
            return response()->json(['statur' => 'success', 'msg' => 'Patient updated successfully']);
        } else {
            return response()->json(['statur' => 'error', 'msg' => 'error in updating post']);
        }
    }
    public function destroy($id)
    {
        $patient = Patient::find($id);
        if ($patient->count()) {
            $patient->delete();
            return response()->json(['statur' => 'success', 'msg' => 'Patient deleted successfully']);
        } else {
            return response()->json(['statur' => 'error', 'msg' => 'error in deleting post']);
        }
    }
}
