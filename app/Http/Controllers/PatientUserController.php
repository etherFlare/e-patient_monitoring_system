<?php

namespace App\Http\Controllers;

use App\Patient;
use App\User;
use Illuminate\Http\Request;

class PatientUserController extends Controller
{
    public function index(Patient $patient, Request $request)
    {
    	$users = $patient->users()->where(function ($query) use ($request) { });

        $users = $users->where(function ($query) use ($request) { });

        $users = $users->orderBy('created_at', 'desc')->paginate($request->get('per_page', 10));
        return $users;
    }
    public function store(Patient $patient, Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
        ]);

        $patient->users()->attach($request->get('user_id'), ['status' => 'new', 'context' => '{}']);
        return response()->json(['status' => 'success', 'msg' => '... assigned successfully']);
    }
    public function show(Patient $patient, User $user)
    {
    	return $patient->users()->where('user_id', $user->id)->first();
    }
    public function update(Patient $patient, User $user, Request $request)
    {
        $rel = $patient->users()->where('user_id', $user->id)->first();

        $payload_ = [
            'status'  => $request->get('status', $rel->status),
            'context' => $request->get('context', $rel->context),
        ];

        $patient->users()->updateExistingPivot($user->id, $payload_);
        return response()->json(['status' => 'success', 'msg' => '... updated successfully']);
    }
    public function destroy(Patient $patient, User $user)
    {
        $patient->users()->detach($user->id);
        return response()->json(['status' => 'success', 'msg' => '... deleted successfully']);
    }
}
