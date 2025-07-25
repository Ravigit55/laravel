<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;


class MemberController extends Controller
{
   

public function getPoints($id)
{
    $member = Member::findOrFail($id);
    return response()->json([
        'member_id' => $member->id,
        'name' => $member->name,
        'points_balance' => $member->points_balance
    ]);
}

// create user 
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|unique:members,phone|max:15|regex:/^[0-9]+$/',
        'password' => 'required|string|min:6',
    ], [
        'name.required' => 'The name field is required.',
        'phone.required' => 'The phone number is required.',
        'phone.unique' => 'This phone number is already registered.',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 6 characters.',
    ]);

    $member = Member::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'password' => Hash::make($request->password), // ✅ Important
        'points_balance' => 0
    ]);

    return response()->json([
        'message' => 'Member created successfully',
        'member' => $member
    ], 201);
}
// Userlogin 
public function login(Request $request)
{
    // Validate input
    $request->validate([
        'phone' => 'required|string',
        'password' => 'required|string'
    ], [
        'phone.required' => 'Phone number is required.',
        'password.required' => 'Password is required.'
    ]);

    // Find member by phone
    $member = Member::where('phone', $request->phone)->first();

    if (!$member || !Hash::check($request->password, $member->password)) {
        return response()->json([
            'message' => 'Invalid phone number or password.'
        ], 401);
    }

    // Success
    return response()->json([
        'message' => 'Login successful.',
        'member' => $member
    ]);
}
//get user details
public function profile(Request $request)
{
    $request->validate([
        'id' => 'required|integer|exists:members,id'
    ], [
        'id.required' => 'Member ID is required.',
        'id.integer' => 'Member ID must be a number.',
        'id.exists' => 'Member not found.'
    ]);

    $member = Member::find($request->id);

    return response()->json($member);
}
// Get member points 
public function getPointsByQuery(Request $request)
{
    $request->validate([
        'id' => 'nullable|integer|exists:members,id',
        'phone' => 'nullable|string|exists:members,phone',
    ], [
        'id.exists' => 'No member found with this ID.',
        'phone.exists' => 'No member found with this phone number.'
    ]);

    // Ensure at least one of 'id' or 'phone' is present
    if (!$request->has('id') && !$request->has('phone')) {
        return response()->json(['message' => 'Please provide either member ID or phone number.'], 400);
    }

    $member = null;

    if ($request->filled('id')) {
        $member = Member::find($request->id);
    } elseif ($request->filled('phone')) {
        $member = Member::where('phone', $request->phone)->first();
    }

    if (!$member) {
        return response()->json(['message' => 'Member not found'], 404);
    }

    return response()->json([
        'member_id' => $member->id,
        'name' => $member->name,
        'points_balance' => $member->points_balance,
    ]);
}

}
