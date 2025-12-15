<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\WalletModel;
use App\Models\WithdrawRequest;
use Carbon\Carbon;

class WithdrawController extends Controller
{
    public function showForm()
    {
        $wallet = WalletModel::where('user_id', Auth::id())->first();
        return view('frontend.withdraw.form', compact('wallet'));
    }

    public function submitRequest(Request $request)
    {
        // ✅ Validate amount (MAX ₹500)
        $request->validate([
            'amount' => 'required|numeric|min:1|max:500',
        ], [
            'amount.max' => 'Maximum withdraw amount is ₹500',
        ]);

        $userId = Auth::id();

        // ✅ Check last withdraw within 24 hours
        $lastWithdraw = WithdrawRequest::where('user_id', $userId)
            ->where('created_at', '>=', Carbon::now()->subHours(24))
            ->first();

        if ($lastWithdraw) {
            return back()->withErrors([
                'amount' => 'Max withdrawal ₹500. One request per 24 hours only so please try tomorrow.',
            ]);
        }

        // ✅ Wallet check
        $wallet = WalletModel::where('user_id', $userId)->first();

        if (!$wallet || $wallet->balance < $request->amount) {
            return back()->withErrors([
                'amount' => 'Insufficient wallet balance.',
            ]);
        }

        // ✅ Create withdraw request
        WithdrawRequest::create([
            'user_id' => $userId,
            'amount'  => $request->amount,
            'status'  => 'pending',
        ]);

        // ✅ Deduct wallet balance immediately
        $wallet->decrement('balance', $request->amount);

        return redirect()
            ->route('customer.withdraw')
            ->with('success', 'Withdraw request submitted successfully. You can withdraw again after 24 hours.');
    }
}
