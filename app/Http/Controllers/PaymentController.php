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

        if (in_array($booking->status, ['confirmed', 'completed', 'cancelled'])) {
            return redirect()->route('dashboard')
                ->with('info', 'Booking ini sudah tidak dapat dibayar.');
        }

        if ($booking->payment) {
            return redirect()->route('payment.status', $booking->payment);
        }

        return view('payment.form', [
            'booking' => $booking,
            'studio' => $booking->studio,
        ]);
    }

    public function create(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->payment) {
            return redirect()->route('payment.status', $booking->payment)
                ->with('info', 'Anda sudah memiliki pembayaran untuk booking ini.');
        }

        $request->validate([
            'method' => 'required|in:' . implode(',', Payment::METHODS),
        ]);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'order_id' => Payment::generateOrderId(),
            'method' => $request->method,
            'amount' => $booking->total_harga,
            'status' => Payment::STATUS_PENDING,
            'expired_at' => now()->addHours(24),
        ]);

        return redirect()->route('payment.status', $payment)
            ->with('success', 'Pembayaran berhasil dibuat! Silakan lakukan pembayaran.');
    }

    public function status(Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        if ($payment->isPending() && $payment->isExpired()) {
            $payment->markAsExpired();
        }

        return view('payment.status', compact('payment'));
    }

    public function uploadProof(Request $request, Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$payment->isPending()) {
            return back()->with('error', 'Tidak dapat upload bukti untuk pembayaran ini.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($payment->payment_proof) {
            Storage::disk('public')->delete($payment->payment_proof);
        }

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

        if (!$payment->isPending()) {
            return back()->with('error', 'Pembayaran tidak dapat dibatalkan.');
        }

        $payment->update(['status' => Payment::STATUS_FAILED]);
        $payment->booking->update(['status' => 'cancelled']);

        return redirect()->route('dashboard')
            ->with('success', 'Pembayaran dibatalkan.');
    }

    public function simulate(Payment $payment)
    {
        if (app()->environment('production')) {
            abort(404);
        }

        if (!$payment->isPending()) {
            return back()->with('error', 'Pembayaran sudah tidak pending.');
        }

        $payment->markAsPaid();

        return redirect()->route('payment.status', $payment)
            ->with('success', '[SIMULASI] Pembayaran berhasil! Booking dikonfirmasi.');
    }

    public function verify(Payment $payment)
    {
        if (!$payment->isPending()) {
            return back()->with('error', 'Pembayaran tidak dapat diverifikasi.');
        }

        $payment->markAsPaid();

        return back()->with('success', 'Pembayaran berhasil diverifikasi! Booking dikonfirmasi.');
    }
}