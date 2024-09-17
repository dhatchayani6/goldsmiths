<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayPalTransactionController extends Controller
{

    // PayPal API credentials (sandbox or live)
    private $clientId = 'YOUR_PAYPAL_CLIENT_ID';
    private $clientSecret = 'YOUR_PAYPAL_CLIENT_SECRET';
    private $baseUrl = 'https://api.sandbox.paypal.com'; // Use https://api.paypal.com for live

    // Create PayPal Order
    public function createOrder(Request $request)
    {
        // Define the order details
        $item = $request->input('item');
        $amount = 100; // Set the price dynamically based on the item

        try {
            // Get PayPal access token
            $accessToken = $this->getAccessToken();

            // Create the order
            $response = Http::withToken($accessToken)->post("{$this->baseUrl}/v2/checkout/orders", [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => 'USD',
                            'value' => $amount,
                        ],
                        'description' => 'Item description', // You can customize this
                    ],
                ],
            ]);

            $order = $response->json();

            // Store order in the database
            PayPalTransaction::create([
                'order_id' => $order['id'],
                'amount' => $amount,
                'currency' => 'USD',
                'status' => 'CREATED',
            ]);

            // Return the PayPal order ID
            return response()->json([
                'id' => $order['id'],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Capture PayPal Order
    public function captureOrder($orderID)
    {
        try {
            // Get PayPal access token
            $accessToken = $this->getAccessToken();

            // Capture the payment
            $response = Http::withToken($accessToken)->post("{$this->baseUrl}/v2/checkout/orders/{$orderID}/capture");

            $orderData = $response->json();

            // Update the transaction status in the database
            $transaction = PayPalTransaction::where('order_id', $orderID)->first();
            if ($transaction) {
                $transaction->status = $orderData['status'];
                $transaction->payer_id = $orderData['payer']['payer_id'] ?? null;
                $transaction->payer_email = $orderData['payer']['email_address'] ?? null;
                $transaction->save();
            }

            return response()->json($orderData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Helper function to get PayPal Access Token
    private function getAccessToken()
    {
        $response = Http::asForm()->withBasicAuth($this->clientId, $this->clientSecret)->post("{$this->baseUrl}/v1/oauth2/token", [
            'grant_type' => 'client_credentials',
        ]);

        $data = $response->json();
        return $data['access_token'];
    }
}
