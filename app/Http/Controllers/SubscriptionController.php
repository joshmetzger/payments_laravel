<?php

namespace App\Http\Controllers;

use App\Resolvers\PaymentPlatformResolver;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\PaymentPlatform;

class SubscriptionController extends Controller
{
    protected $paymentPlatformResolver;

    public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
    {
        $this->middleware('auth');

        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }
    //
    public function show()
    {
        $paymentPlatforms = PaymentPlatform::where('subscriptions_enabled', true)->get();
        // $paymentPlatforms = PaymentPlatform::get();

        return view('subscribe')->with([
            'plans'=> Plan::all(),
            'paymentPlatforms'=> $paymentPlatforms,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'plan' => ['required', 'exists:plans,slug'],
            'payment_platform' => ['required', 'exists:payment_platforms,id'],
        ];

        $request->validate($rules);

        $paymentPlatform = $this->paymentPlatformResolver
            ->resolveService($request->payment_platform);

        session()->put('subscriptionPlatformId', $request->payment_platform);

        return $paymentPlatform->handleSubscription($request);
    }

    public function approval()
    {
        
    }

    public function cancelled()
    {
        
    }
}
