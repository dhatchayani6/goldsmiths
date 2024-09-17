<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class OrderController extends Controller
{
 // Create an order
 public function createOrder(Request $request)
 {
     // Validate request
     $request->validate([
         'amount' => 'required|numeric|min:0.01',
         'currency' => 'required|string',
         'description' => 'required|string'
     ]);

     // Set up PayPal API credentials
     $clientId = env('s3IdBaQuVPFocouusQwNSMeNUL9n6TEAGowSRwVG5Q3Ax3ojl0irQqZPd4gVThfLAUSsk');
     $clientSecret = env('s3IdBaQuVPFocouusQwNSMeNUL9n6TEAGowSRwVG5Q3Ax3ojl0irQqZPd4gVThfLAUSsk');

     // Create PayPal order
     $response = Http::withBasicAuth($clientId, $clientSecret)
         ->post('https://api-m.sandbox.paypal.com/v2/checkout/orders', [
             'intent' => 'CAPTURE',
             'purchase_units' => [
                 [
                     'amount' => [
                         'currency_code' => $request->currency,
                         'value' => $request->amount,
                     ],
                     'description' => $request->description,
                 ],
             ],
         ]);

     // Check for errors
     if ($response->failed()) {
         return response()->json(['error' => 'Error creating PayPal order'], 500);
     }

     // Return the order ID to the client
     $orderId = $response->json('id');
     return response()->json(['id' => $orderId]);
 }

 // Capture an order
 public function captureOrder($orderId)
 {
     // Set up PayPal API credentials
     $clientId = env('Aew2g2XOHD-s3IdBaQuVPFocouusQwNSMeNUL9n6TEAGowSRwVG5Q3Ax3ojl0irQqZPd4gVThfLAUSsk');
     $clientSecret = env('Aew2g2XOHD-s3IdBaQuVPFocouusQwNSMeNUL9n6TEAGowSRwVG5Q3Ax3ojl0irQqZPd4gVThfLAUSsk');

     // Capture PayPal order
     $response = Http::withBasicAuth($clientId, $clientSecret)
         ->post("https://api-m.sandbox.paypal.com/v2/checkout/orders/{$orderId}/capture");

     // Check for errors
     if ($response->failed()) {
         return response()->json(['error' => 'Error capturing PayPal order'], 500);
     }

     // Return the capture response
     return response()->json($response->json());
 }}
