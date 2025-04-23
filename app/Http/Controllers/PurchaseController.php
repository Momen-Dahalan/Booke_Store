<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PurchaseController extends Controller
{

    private $provider;

    // يستخدم هذا الباني لتجهيز إعدادات الاتصال مع PayPal عند إنشاء هذا الكائن.

    function __construct()
    {
        $this->provider= new PayPalClient;
        
        $this->provider->setApiCredentials(config('paypal'));
        $token = $this->provider->getAccessToken();
        $this->provider->setAccessToken($token);
        
    }



    public function createPayment(Request $request)
    {
        // ترجيع البيانات التي ارسلناها من كارت في داخل الفيتش الي هوا اليوزر ايدي من خلال جيسون ديكود 
        //عشان احولو الي متغير بي اتش بي بستخدم جيسون ديكود خيار ترو يحول الداتا الي مصفوفة ترابطية
        $data = json_decode($request->getContent(), true);

        $books = User::find($data['userId'])->booksInCart;
        $total = 0;

        foreach ($books as $book) {
            $total += $book->price * $book->pivot->number_of_copies;
        }

        // بدي اجهز الطلبية 

        $order = $this->provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $total
                    ],
                    'description' => 'Order Description'
                ]
            ]
        ]);
        // ارسلت رد هتستقبلو الريسبونس في الذن في كارت 
        return response()->json($order);
    }


    // تنفيذ عملية الدفع 
    public function executePayment(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $result = $this->provider->capturePaymentOrder($data['orderId']);
        if ($result['status'] === 'COMPLETED') {
            $user = User::find($data['userId']);
            $books = $user->booksInCart;

            foreach ($books as $book) {
                $bookPrice = $book->price;
                $purchaseTime = Carbon::now();
                $user->booksInCart()->updateExistingPivot($book->id, ['bought' => true, 'price' => $bookPrice, 'created_at' => $purchaseTime]);
                $book->save();
            }
        }

        return response()->json($result);
    }
}
