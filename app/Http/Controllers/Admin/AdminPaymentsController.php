<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminPaymentsController extends BaseController
{
    /**
     * Display all payments
     */
    public function index(Request $request)
    {
        $payments = Payment::with(['user', 'subscription.plan'])
            ->latest()
            ->paginate(10);

        return view('Admin.payments.index', [
            'payments' => $payments,
            'statuses' => ['paid', 'failed'] // For filter dropdown
        ]);
    }

    /**
     * Show payment details
     */
    public function show(Payment $payment)
    {
        $payment->load(['user', 'subscription.plan']);
        
        return view('Admin.payments.show', [
            'payment' => $payment
        ]);
    }

    /**
     * Delete a payment record
     */
    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();
            return redirect()->route('admin.payments.index')
                ->with('success', 'Payment deleted successfully');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete payment: ' . $e->getMessage());
        }
    }
}