<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment.index');
    }

    public function submit(Request $request)
    {
        $registrationPrice = session('registration_price');
    
        // Validasi dengan aturan dinamis
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
        ]);
    
        $amount = $validated['amount'];
    
        if ($amount < $registrationPrice) {
            $underpaid = $registrationPrice - $amount;
            return back()->withErrors(['amount' => __('payment.underpaid_msg') . ' ' . $underpaid]);
        }
    
        if ($amount > $registrationPrice) {
            $overpaid = $amount - $registrationPrice;
    
            return view('payment.confirmation', [
                'overpaid' => $overpaid,
            ]);
        }
    
        return redirect('/login')->with('success', __('payment.payment_success_msg'));
    }    

    public function confirmOverpayment(Request $request)
    {
        // Ambil jumlah overpaid dari request
        $overpaid = $request->input('overpaid');
        $decision = $request->input('decision'); // "yes" or "no"

        if ($decision === 'yes') {
            // Logika untuk menambahkan saldo ke wallet pengguna
            $user = session('user');
            $user->wallet_balance = ($user->wallet_balance ?? 0) + $overpaid;
            $user->save();

            return redirect('/login')->with('success', __('payment.overpaid_added_to_wallet_msg'));
        }

        if ($decision === 'no') {
            // Arahkan kembali ke halaman pembayaran untuk mengisi jumlah yang benar
            return redirect()->route('payments.payment')->withErrors(['amount' => __('payment.overpaid_error_msg')]);
        }

        // Jika tidak ada keputusan yang valid
        return redirect('/login')->with('error', 'Invalid operation.');
    }

}
