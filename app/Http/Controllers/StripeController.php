<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\StripeClient;

class StripeController extends Controller
{

    public $stripe ;


    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));

    }

    

}
