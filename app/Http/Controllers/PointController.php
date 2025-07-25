<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\Redemption;


class PointController extends Controller
{
    // Calculate total points 
    public function calculatePoints(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id'
        ]);

        $totalPoints = Transaction::where('member_id', $request->member_id)
            ->sum('points_earned');

        return response()->json([
            'member_id' => $request->member_id,
            'total_points_earned' => $totalPoints
        ]);
    }

    // add points manually 
    public function addManualPoints(Request $request)
{
    $request->validate([
        'member_id' => 'required|exists:members,id',
        'points' => 'required|integer|min:1',
        'description' => 'nullable|string'
    ]);

    $member = Member::find($request->member_id);
    $member->increment('points_balance', $request->points);

    // Optionally store as a transaction (to keep history)
    $transaction = Transaction::create([
        'member_id' => $member->id,
        'purchase_amount' => 0,
        'points_earned' => $request->points,
        'description' => $request->description ?? 'Manual point addition'
    ]);

    return response()->json([
        'message' => 'Points added successfully',
        'member_id' => $member->id,
        'points_added' => $request->points,
        'new_balance' => $member->points_balance,
        'transaction_id' => $transaction->id
    ]);
}

// redeem points for a user 

public function redeemPoints(Request $request)
{
    $request->validate([
        'member_id' => 'required|exists:members,id',
        'points' => 'required| integer |in:100,200', // only allow 100 or 200
    ], [
        'member_id.required' => 'The member ID is required.',
        'member_id.exists' => 'The specified member does not exist.',
        'points.required' => 'The points field is required.',
        'points.integer' => 'The points must be a valid integer.',
        'points.in' => 'Only accept value more then 100.',
    ]);

    $discountMap = [
        100 => 5,
        200 => 10
    ];

    $member = Member::find($request->member_id);

    if ($member->points_balance < $request->points) {
        return response()->json(['message' => 'Insufficient points.'], 400);
    }

    // Deduct points
    $member->points_balance -= $request->points;
    $member->save();

    // Save redemption record
    $redemption = Redemption::create([
        'member_id' => $member->id,
        'points_used' => $request->points,
        'discount_amount' => $discountMap[$request->points],
    ]);

    return response()->json([
        'message' => 'Points redeemed successfully.',
        'member_id' => $member->id,
        'points_used' => $request->points,
        'discount_applied' => $discountMap[$request->points],
        'new_balance' => $member->points_balance,
        'redemption_id' => $redemption->id
    ]);
}

}
