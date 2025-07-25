<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Member;

class TransactionController extends Controller
{
    
// add transection 
public function store(Request $request)
{
    $request->validate([
        'member_id' => 'required|exists:members,id',
        'purchase_amount' => 'required|numeric|min:0',
        'includes_alcohol' => 'required|boolean',
        'description' => 'nullable|string'
    ], [
        'member_id.required' => 'The member ID is required.',
        'member_id.exists' => 'The specified member ID does not exist.',
        'purchase_amount.required' => 'The purchase amount is required.',
        'purchase_amount.numeric' => 'The purchase amount must be a number.',
        'purchase_amount.min' => 'The purchase amount must be at least 0.',
        'includes_alcohol.required' => 'Please specify if the purchase includes alcohol.',
        'includes_alcohol.boolean' => 'The alcohol field must be true or false.',
        'description.string' => 'The description must be a valid string.'
    ]);

    $points = $request->includes_alcohol ? 0 : floor($request->purchase_amount / 10);

    // Create transaction
    $transaction = Transaction::create([
        'member_id' => $request->member_id,
        'purchase_amount' => $request->purchase_amount,
        'points_earned' => $points,
        'description' => $request->description,
    ]);

    // Update member's points balance
    $member = Member::find($request->member_id);
    $member->increment('points_balance', $points);

    return response()->json([
        'message' => 'Transaction recorded successfully.',
        'points_earned' => $points,
        'transaction' => $transaction
    ], 201);
}

// Get transection history
public function getPurchaseHistory(Request $request)
{
    $request->validate([
        'id' => 'required|integer|exists:members,id'
    ], [
        'id.required' => 'Member ID is required.',
        'id.exists' => 'No member found with this ID.'
    ]);

    $member = Member::find($request->id);

    $history = $member->transactions()->select('id', 'purchase_amount', 'points_earned', 'description', 'created_at')->latest()->get();

    return response()->json([
        'member_id' => $member->id,
        'name' => $member->name,
        'history' => $history
    ]);
}

}
