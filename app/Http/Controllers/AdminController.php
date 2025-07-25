<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Transaction;

class AdminController extends Controller
{
    public function showLogin() {
        return view('admin.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('admin.members');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function memberList() {
        $members = Member::all();
        return view('admin.members', compact('members'));
    }

    public function transactions() {
        $transactions = Transaction::with('member')->latest()->get();
        return view('admin.transactions', compact('transactions'));
    }

    public function createMember() {
        return view('admin.add_member');
    }

    public function storeMember(Request $request) {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:members',
            'password' => 'required'
        ]);

        Member::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'points_balance' => 0
        ]);

        return redirect()->route('admin.members')->with('success', 'Member added successfully.');
    }
}
