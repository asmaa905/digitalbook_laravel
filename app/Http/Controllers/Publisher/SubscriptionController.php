<?php

namespace App\Http\Controllers\Publisher;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Payment;
use App\Services\FatooraService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends BaseController
{
    protected $fatooraService;

    public function __construct(FatooraService $fatooraService)
    {
        $this->fatooraService = $fatooraService;
    }

    /**
     * Display available subscription plans
     */
    public function plans()
    {
        $plans = Plan::all();
            $user = auth()->user();
            
            // Check if user has any active subscription
            $hasActiveSubscription = $user->subscriptions()
                ->where('status', 'confirm')
                ->where(function($query) {
                    $query->where('end_date', '>', now())
                          ->orWhereNull('end_date');
                })
                ->exists();
        
        return view('Publisher.subscriptions.plans', [
            'plans' => $plans,
            'hasActiveSubscription'=>$hasActiveSubscription
        ]);
    }

    /**
     * Display the user's subscriptions
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get the most recent subscription for each plan
        $subscriptions = $user->subscriptions()
            ->with(['plan', 'payment'])
            ->whereIn('id', function($query) use ($user) {
                $query->selectRaw('MAX(id)')
                    ->from('subscriptions')
                    ->where('user_id', $user->id)
                    ->groupBy('plan_id');
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        $payments = $user->payments()
            ->with(['subscription.plan'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Publisher.subscriptions.index', [
            'subscriptions' => $subscriptions,
            'payments' => $payments,
            'user' => $user
        ]);
    }
    public function show(Subscription $subscription)
    {
        // Authorization - ensure the subscription belongs to the authenticated user
        if ($subscription->user_id !== Auth::id()) {
            abort(403);
        }

        return view('publisher.subscriptions.show', [
            'subscription' => $subscription->load(['plan', 'payment', 'user'])
        ]);
    }
    public function payments()
    {
        $user = Auth::user();
        
        $subscriptions = $user->subscriptions()
            ->with(['plan', 'payment']) 
            ->orderBy('created_at', 'desc')
            ->get();
            
        $payments = $user->payments()
            ->with(['subscription.plan'])
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('Publisher.subscriptions.payments', [
            'subscriptions' => $subscriptions,
            'payments' => $payments,
            'user' => $user
        ]);
    }
    public function payment_show(Payment $payment)
    {
        // Authorization - ensure the payment belongs to the authenticated user
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        return view('Publisher.subscriptions.show-payment', [
            'payment' => $payment->load(['subscription.plan', 'user'])
        ]);
    }

    /**
     * Initiate new subscription payment
     */
    public function subscribe(Request $request, Plan $plan)
    {
        $user = Auth::user();
        
        // Check if user already has an active subscription for this plan
        $activeSubscription = $user->subscriptions()
            ->where('plan_id', $plan->id)
            ->where(function($query) {
                $query->where('end_date', '>', now())
                      ->orWhereNull('end_date');
            })
            ->first();

        if ($activeSubscription) {
            return redirect()->route('subscriptions.plans')
                ->with('error', 'You already have an active subscription for this plan.');
        }

        // Prepare payment data for MyFatoorah
        $paymentData = [
            'plan_id' => $plan->id,
            'user_id' => $user->id,
            'total_amount' => $plan->price,
            'type' => 'new' // Indicates this is a new subscription
        ];

        // Store payment data in session temporarily
        $request->session()->put('subscription_payment', $paymentData);

        // Redirect to payment gateway
        return $this->initiatePayment($plan);
    }

    /**
     * Initiate subscription renewal payment
     */
    public function renew(Request $request, Plan $plan)
    {
        $user = Auth::user();
        
        // Prepare payment data for MyFatoorah
        $paymentData = [
            'plan_id' => $plan->id,
            'user_id' => $user->id,
            'total_amount' => $plan->price,
            'type' => 'renewal' // Indicates this is a renewal
        ];

        // Store payment data in session temporarily
        $request->session()->put('subscription_payment', $paymentData);

        // Redirect to payment gateway
        return $this->initiatePayment($plan);
    }

    /**
     * Initiate payment with MyFatoorah
     */
    protected function initiatePayment(Plan $plan)
    {
        $user = Auth::user();
        
        $data = [
            "CustomerName" => $user->name,
            "NotificationOption" => 'LNK',
            'InvoiceValue' => $plan->price,
            "CustomerEmail" => $user->email,
            "CallBackUrl" => route('publisher.subscriptions.payment.callback'),
            "ErrorUrl" => route('publisher.subscriptions.payment.error'),
            "Language" => 'en',
            "DisplayCurrencyIso" => 'EGP',
            "UserDefinedField" => json_encode([
                'plan_id' => $plan->id,
                'user_id' => $user->id
            ])
        ];
        
        $response = $this->fatooraService->sendPayment($data);
        
        if (!$response || !isset($response['IsSuccess'])) {
            return redirect()->back()->with('error', 'Failed to initiate payment. Please try again.');
        }

        // Store payment ID in session for verification later
        session(['myfatoorah_invoice_id' => $response['Data']['InvoiceId']]);

        // Redirect to payment page
        return redirect($response['Data']['InvoiceURL']);
    }

    /**
     * Handle successful payment callback
     */
    public function paymentCallback(Request $request)
    {
        // Verify payment with MyFatoorah
        // dd($request);
        $paymentId = $request->paymentId ?? $request->input('paymentId');
        
        if (!$paymentId) {
            return redirect()->route('publisher.subscriptions.payment.error')
                ->with('error', 'Payment ID not found in callback.');
        }

        $data = [
            'Key' => $paymentId,
            'KeyType' => 'paymentId'
        ];

        $paymentStatus = $this->fatooraService->getPaymentStatus($data);
        if (!$paymentStatus || !$paymentStatus['IsSuccess']) {
            return redirect()->route('publisher.subscriptions.payment.error')
                ->with('error', 'Payment verification failed.');
        }

        // Get payment data from MyFatoorah response
        $paymentData = $paymentStatus['Data'] ?? null;
        if (!$paymentData) {
            return redirect()->route('publisher.subscriptions.payment.error')
                ->with('error', 'Invalid payment data received.');
        }

        // Get the subscription data from session
        $subscriptionData = session('subscription_payment');
        if (!$subscriptionData) {
            return redirect()->route('publisher.subscriptions.plans')
                ->with('error', 'Session expired. Please try again.');
        }

        $user = Auth::user();
        $plan = Plan::find($subscriptionData['plan_id']);

        // Create payment record
        $payment = $this->createPaymentRecord($user, $plan, $paymentData);

        // Create or update subscription based on payment type
        if ($subscriptionData['type'] === 'renewal') {
            $subscription = $this->renewSubscription($user, $plan, $payment);
        } else {
            $subscription = $this->createSubscription($user, $plan, $payment);
        }

        // Clear session data
        $request->session()->forget(['subscription_payment', 'myfatoorah_invoice_id']);

        return view('Publisher.payments.success', [
            'payment' => $payment,
            'subscription' => $subscription,
            'user' => $user,
            'paymentId' => $paymentData['paymentId'] ?? $payment->transaction_id,
            'amount' => $paymentData['InvoiceDisplayValue'] ?? $payment->total_amount,
            'data_transaction' => $paymentData
        ]);
    }



    /**
     * Handle payment error
     */
    public function paymentError(Request $request)
    {
        $errorMessage = $request->input('Error') ?? 'Payment was cancelled or failed';
        
        // Clear session data
        $request->session()->forget(['subscription_payment', 'myfatoorah_invoice_id']);

        return view('Publisher.payments.error', [
            'errorMessage' => $errorMessage,
            'supportEmail' => 'support@example.com'
        ]);
    }

    /**
     * Create payment record
     */
     /**
     * Create payment record with proper MyFatoorah fields
     */
    protected function createPaymentRecord($user, $plan, $paymentData)
    {
        $payment = new Payment();
        $payment->user_id = $user->id;        
        // Use the first transaction if available
        $transaction = $paymentData['InvoiceTransactions'][0] ?? null;
        $payment->total_amount = $plan->price;       
        $payment->payment_method = $transaction['PaymentGateway'] ?? 'MyFatoorah';
        $payment->transaction_id = $paymentData['InvoiceId'] ?? uniqid('pay_');       
        $payment->status = (strtolower($paymentData['InvoiceStatus'] ?? '') === 'paid' && 
                           ($transaction['TransactionStatus'] ?? '') === 'Succss') 
                           ? 'paid' : 'failed';
        // dd($paymentData);
        $payment->invoice_reference = $paymentData['InvoiceReference'] ?? 'INV-'.strtoupper(uniqid());
        $payment->paid_date = Carbon::now();
        $payment->card_number = $transaction['CardNumber'] ?? '**** **** **** ****';       
        $payment->save();
        return $payment;
    }

    /**
     * Create new subscription
     */
    protected function createSubscription($user, $plan, $payment)
    {
        $subscription = new Subscription();
        $subscription->user_id = $user->id;
        $subscription->plan_id = $plan->id;
        $subscription->payment_id = $payment->id;
        $subscription->start_date = Carbon::now();
        
        if ($plan->plan_duration > 0) {
            $subscription->end_date = Carbon::now()->addMonths($plan->plan_duration);
        }
        
        $subscription->status = 'confirm';
        $subscription->save();

        return $subscription;
    }

    /**
     * Renew existing subscription
     */
    protected function renewSubscription($user, $plan, $payment)
    {
        $subscription = new Subscription();
        $subscription->user_id = $user->id;
        $subscription->plan_id = $plan->id;
        $subscription->payment_id = $payment->id;
        $subscription->start_date = Carbon::now();
        
        if ($plan->plan_duration > 0) {
            $subscription->end_date = Carbon::now()->addMonths($plan->plan_duration);
        }
        
        $subscription->status = 'confirm';
        $subscription->save();

        return $subscription;
    }
    /**
     * Cancel a subscription before it expires
     */
    public function cancel(Subscription $subscription)
    {
        // Authorization
        if ($subscription->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if subscription is already expired
        if ($subscription->end_date && $subscription->end_date->lt(now())) {
            return redirect()->back()->with('error', 'This subscription has already expired.');
        }

        // Update the end date to now
        $subscription->update([
            'end_date' => now(),
            'status' => 'canceled'
        ]);

        return redirect()->route('publisher.subscriptions.index')
            ->with('success', 'Subscription canceled successfully.');
    }
    public function downloadPaymentDetails(Payment $payment)
    {
        // Authorization check
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        $data = [
            'payment' => $payment->load(['subscription.plan', 'user'])
        ];

        $pdf = PDF::loadView('publisher.payments.download', $data);
        return $pdf->download('payment_'.$payment->transaction_id.'.pdf');

           }
}