<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Jewel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class PurchaseController extends Controller
{
    public function show_purchase($id)
    {
        // Fetch the jewel data based on its ID
        $fetchjewel = Jewel::find($id); // Or use where clause if needed

        // Check if jewel exists
        if (!$fetchjewel) {
            return redirect()->back()->with('error', 'Jewel not found.');
        }

        // Pass the $fetchjewel data to the view
        return view('user.purchase', compact('fetchjewel'));
    }

    public function storepurchasedetails(Request $request)
    {
         // Validate request data
    $validatedData = $request->validate([
        'jewel_id' => 'required|integer',
        'customer_name' => 'required|string|min:2',
        'email' => 'required|email',
        'mobile_number' => 'required|regex:/^[0-9]{10}$/',
        'zip_code' => 'required|regex:/^[0-9]{5}$/',
        'address' => 'required|string',
        'payment_method' => 'required|string',
        'paypal_order_id' => 'nullable|string', // Only if applicable
        'amount' => 'required|numeric', // Ensure amount is validated as numeric
    ]);

    // Save data to the database
    $purchase = new Purchase();
    $purchase->jewel_id = $validatedData['jewel_id'];
    $purchase->customer_name = $validatedData['customer_name'];
    $purchase->email = $validatedData['email'];
    $purchase->mobile_number = $validatedData['mobile_number'];
    $purchase->zip_code = $validatedData['zip_code'];
    $purchase->address = $validatedData['address'];
    $purchase->payment_method = $validatedData['payment_method'];
    $purchase->paypal_order_id = $validatedData['paypal_order_id'];
    $purchase->amount = $validatedData['amount']; // Store the amount
    $purchase->save();

    return redirect()->back()->with('success', 'Purchase successful!');
    }

    public function fetch_jewel()
    {
        $fetchjewel = Jewel::all();
        return response()->json($fetchjewel);
    }

    public function getpurchase(){
        $fetchpurchase = Purchase::all();
        return view('smith.payment-status',compact('fetchpurchase')); 
    }

    private $paypalClientId;
    private $paypalClientSecret;

    public function __construct()
    {
        $this->paypalClientId = env('Aew2g2XOHD-s3IdBaQuVPFocouusQwNSMeNUL9n6TEAGowSRwVG5Q3Ax3ojl0irQqZPd4gVThfLAUSsk');
        $this->paypalClientSecret = env('Aew2g2XOHD-s3IdBaQuVPFocouusQwNSMeNUL9n6TEAGowSRwVG5Q3Ax3ojl0irQqZPd4gVThfLAUSsk');
    }
    private function getAccessToken()
    {
        $response = Http::withBasicAuth($this->paypalClientId, $this->paypalClientSecret)
            ->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        $data = $response->json();
        return $data['access_token'];
    }

    public function createOrder(Request $request)
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->post('https://api-m.sandbox.paypal.com/v2/checkout/orders', [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => 'USD',
                            'value' => 1, // Replace with actual price
                        ],
                    ],
                ],
            ]);

        $orderData = $response->json();
        return response()->json(['id' => $orderData['id']]);
    }

    public function captureOrder($orderId)
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->post("https://api-m.sandbox.paypal.com/v2/checkout/orders/{$orderId}/capture");

        $captureData = $response->json();
        return response()->json($captureData);
    }
}
