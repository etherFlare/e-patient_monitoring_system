<?php

namespace App\Http\Controllers;

use App\Patient;
use App\User;
use Illuminate\Http\Request;

class UserPatientController extends Controller
{
    public function index(User $user, Request $request)
    {
    	$patients = $user->patients()->where(function ($query) use ($request) { });

        $patients = $patients->where(function ($query) use ($request) { });

        $patients = $patients->orderBy('created_at', 'desc')
        ->with(['location','unit'])
        ->paginate($request->get('per_page', 10));
        return $patients;
    }
    public function store(User $user, Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
        ]);

        $user->patients()->attach($request->get('user_id'), ['status' => 'new', 'context' => '{}']);
        return response()->json(['status' => 'success', 'msg' => '... assigned successfully']);
    }
    public function show(User $user, Patient $patient)
    {
    	return $user->patients()->where('user_id', $user->id)->first();
    }
    public function update(User $user, Patient $patient, Request $request)
    {
        $rel = $user->patients()->where('user_id', $user->id)->first();

        $payload_ = [
            'status'  => $request->get('status', $rel->status),
            'context' => $request->get('context', $rel->context),
        ];

        $user->patients()->updateExistingPivot($user->id, $payload_);
        return response()->json(['status' => 'success', 'msg' => '... updated successfully']);
    }
    public function destroy(User $user, Patient $patient)
    {
        $user->patients()->detach($user->id);
        return response()->json(['status' => 'success', 'msg' => '... deleted successfully']);
    }
}
