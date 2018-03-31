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
            'patient.location_id'    => 'required',
            'patient.unit_id'        => 'required',
            'patient.first_name'     => 'required',
            'patient.middle_name'    => 'required',
            'patient.last_name'      => 'required',
            'patient.gender'         => 'required',
            'patient.age'            => 'required',
            'patient.home_address'   => 'required',
            'patient.contact_number' => 'required',
            'patient.contact_person' => 'required',
        ]);
        $createdPatient = Patient::create($request->get('patient'));
        return response()->json(['request' => $request->all(), 'patient' => $createdPatient, 'status' => 'success', 'msg' => 'Patient Created successfully']);
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
            'patient.location_id'    => 'required',
            'patient.unit_id'        => 'required',
            'patient.first_name'     => 'required',
            'patient.middle_name'    => 'required',
            'patient.last_name'      => 'required',
            'patient.gender'         => 'required',
            'patient.age'            => 'required',
            'patient.home_address'   => 'required',
            'patient.contact_number' => 'required',
            'patient.contact_person' => 'required',
        ]);
        $patient = Patient::find($id);
        if ($patient->count()) {
            $patient->update($request->get('patient'));
            return response()->json(['request' => $request->all(), 'patient' => $patient, 'status' => 'success', 'msg' => 'Patient updated successfully']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'error in updating post']);
        }
    }
    public function destroy($id)
    {
        $patient = Patient::find($id);
        if ($patient->count()) {
            $patient->delete();
            return response()->json(['status' => 'success', 'msg' => 'Patient deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'error in deleting post']);
        }
    }
}
