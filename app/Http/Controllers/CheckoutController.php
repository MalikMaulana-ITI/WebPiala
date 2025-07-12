<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification; // Import Notification
use App\Models\Order; // Import Order model
use App\Models\Invoice; // Import Invoice model
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB; // For database transactions

class CheckoutController extends Controller
{
    public function index()
    {
        $selectedProduct = session('selected_product');
        // dd($selectedProduct);    
        return view("pages.product.checkout", compact('selectedProduct'));
    }

    public function processCheckout(Request $request)
    {
        // 1. Validate the request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            // Add validation rules for other fields as needed
        ]);

        $selectedProduct = session('selected_product');

        if (!$selectedProduct) {
            return response()->json(['error' => 'No product selected for checkout.'], 400);
        }

        // Use a database transaction to ensure atomicity
        DB::beginTransaction();
        try {

            $trophyID = $selectedProduct['id'];
            if (isset($selectedProduct['isSpesialCostumize'])) {
                if ($selectedProduct['isSpesialCostumize'] == true) {
                    $trophyID = Null;
                }
            }

            // 2. Save Order Details
            $order = Order::create([
                'buyer_name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'phone_number' => $request->input('phone_number'),
                'email' => $request->input('email'),
                'trophy_id' => $trophyID,
                'isCustomize' => $selectedProduct['isCustomize'] ?? false, // <-- Gunakan 'isCustomize'
                'customize_id' => $selectedProduct['customize_id'] ?? null,
            ]);

            // 3. Save Invoice Details
            $invoiceNumber = 'INV-' . time() . '-' . $order->order_id;
            $invoice = Invoice::create([
                'order_id' => $order->order_id,
                'invoice_number' => $invoiceNumber,
                'amount' => $selectedProduct['final_price'],
                'payment_status' => 'pending',
            ]);

            // 4. Set Midtrans Configuration
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // 5. Prepare Transaction Details for Midtrans
            $grossAmount = $selectedProduct['final_price'];

            $customerDetails = [
                'first_name'    => $request->input('first_name'),
                'last_name'     => $request->input('last_name'),
                'email'         => $request->input('email'),
                'phone'         => $request->input('phone_number'),
                'shipping_address' => [
                    'first_name'    => $request->input('first_name'),
                    'last_name'     => $request->input('last_name'),
                    'phone'         => $request->input('phone_number'),
                    'address'       => $request->input('shipping_address'),
                    'city'          => $request->input('city'),
                    'postal_code'   => '12345', // You might need to add a postal code field
                    'country_code'  => 'IDN', // Or dynamically set based on country input
                ],
            ];

            $itemDetails = [
                [
                    'id'       => $selectedProduct['id'],
                    'price'    => $selectedProduct['final_price'],
                    'quantity' => 1,
                    'name'     => $selectedProduct['name'],
                ]
            ];

            $transactionDetails = [
                'order_id'      => $invoice->invoice_number, // Use invoice number as Midtrans order_id
                'gross_amount'  => $grossAmount,
            ];

            $params = [
                'transaction_details' => $transactionDetails,
                'customer_details'    => $customerDetails,
                'item_details'        => $itemDetails,
                // 'callbacks'           => [ // Optional: for custom redirects after payment
                //     'finish'    => route('payment.finish'),
                //     'unfinish'  => route('payment.unfinish'),
                //     'error'     => route('payment.error'),
                // ]
            ];

            $snapToken = Snap::getSnapToken($params);

            // Update the invoice with the generated snap token
            $invoice->midtrans_snap_token = $snapToken;
            $invoice->save();

            DB::commit(); // Commit the transaction

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle Midtrans payment notifications (webhooks).
     */
    public function paymentNotification(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id; // This is the invoice_number we sent to Midtrans
        $fraudStatus = $notification->fraud_status;
        $midtransTransactionId = $notification->transaction_id; // Midtrans's unique transaction ID

        // Find the invoice using the orderId (which is our invoice_number)
        $invoice = Invoice::where('invoice_number', $orderId)->first();

        if (!$invoice) {
            // Log error: Invoice not found
            return response('Invoice not found', 404);
        }

        // Use a database transaction for updating invoice status
        DB::beginTransaction();
        try {
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $invoice->payment_status = 'challenge';
                } else if ($fraudStatus == 'accept') {
                    $invoice->payment_status = 'paid';
                }
            } else if ($transactionStatus == 'settlement') {
                $invoice->payment_status = 'paid';
            } else if ($transactionStatus == 'pending') {
                $invoice->payment_status = 'pending';
            } else if ($transactionStatus == 'deny') {
                $invoice->payment_status = 'denied';
            } else if ($transactionStatus == 'expire') {
                $invoice->payment_status = 'expired';
            } else if ($transactionStatus == 'cancel') {
                $invoice->payment_status = 'cancelled';
            }

            $invoice->midtrans_transaction_id = $midtransTransactionId; // Store Midtrans transaction ID
            $invoice->save();

            DB::commit();

            return response('OK', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            // Log error: Failed to update invoice status
            return response('Error updating invoice status: ' . $e->getMessage(), 500);
        }
    }
}
