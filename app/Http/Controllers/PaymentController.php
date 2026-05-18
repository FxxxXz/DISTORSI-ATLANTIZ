<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function form(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->payment) {
            return redirect()->route('payment.status', $booking->payment);
        }

        $studio = $booking->studio;

        return view('payment.form', compact('booking', 'studio'));
    }

    public function create(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'method' => 'required|in:transfer_bank,e_wallet,virtual_account,qris',  // ✅ Tambah qris
        ]);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'order_id' => Payment::generateOrderId(),
            'method' => $request->method,
            'amount' => $booking->total_harga,
            'status' => 'pending',
            'expired_at' => now()->addHours(24),
        ]);

        return redirect()->route('payment.status', $payment);
    }

    public function status(Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        if ($payment->status === 'pending' && $payment->isExpired()) {
            $payment->update(['status' => 'expired']);
            $payment->booking->update(['status' => 'cancelled']);
        }

        return view('payment.status', compact('payment'));
    }

    public function uploadProof(Request $request, Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string|max:500',
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $payment->update([
            'payment_proof' => $path,
            'notes' => $request->notes,
        ]);

        return redirect()->route('payment.status', $payment)
            ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
    }

    public function cancel(Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        if ($payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran tidak dapat dibatalkan.');
        }

        $payment->update(['status' => 'failed']);
        $payment->booking->update(['status' => 'cancelled']);

        return redirect()->route('dashboard')
            ->with('success', 'Pembayaran dibatalkan.');
    }

    public function simulate(Payment $payment)
    {
        if (app()->environment('production')) {
            abort(404);
        }

        $payment->markAsPaid();

        return redirect()->route('payment.status', $payment)
            ->with('success', '[SIMULASI] Pembayaran berhasil! Booking dikonfirmasi.');
    }

    public function verify(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran tidak dapat diverifikasi.');
        }

        $payment->markAsPaid();

        return back()->with('success', 'Pembayaran berhasil diverifikasi! Booking dikonfirmasi.');
    }
}