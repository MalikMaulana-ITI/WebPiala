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
use Illuminate\Validation\ValidationException; // Import ValidationException

class CheckoutController extends Controller
{
    public function index()
    {
        $selectedProduct = session('selected_product');
        return view("pages.product.checkout", compact('selectedProduct'));
    }

    public function processCheckout(Request $request)
    {
        // 1. Validate the request data
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email:rfc,dns|max:255', // Improved email validation
                'phone_number' => 'required|string|min:7|max:15|regex:/^[0-9]+$/', // Phone number validation
                'shipping_address' => 'required|string|max:500', // Added max length for address
            ], [
                // Custom error messages
                'first_name.required' => 'Nama depan wajib diisi.',
                'first_name.string' => 'Nama depan harus berupa teks.',
                'first_name.max' => 'Nama depan tidak boleh lebih dari 255 karakter.',
                'last_name.required' => 'Nama belakang wajib diisi.',
                'last_name.string' => 'Nama belakang harus berupa teks.',
                'last_name.max' => 'Nama belakang tidak boleh lebih dari 255 karakter.',
                'email.required' => 'Alamat email wajib diisi.',
                'email.string' => 'Alamat email harus berupa teks.',
                'email.email' => 'Format alamat email tidak valid.',
                'email.max' => 'Alamat email tidak boleh lebih dari 255 karakter.',
                'phone_number.required' => 'Nomor telepon wajib diisi.',
                'phone_number.string' => 'Nomor telepon harus berupa teks.',
                'phone_number.min' => 'Nomor telepon harus memiliki setidaknya 7 karakter.',
                'phone_number.max' => 'Nomor telepon tidak boleh lebih dari 15 karakter.',
                'phone_number.regex' => 'Nomor telepon hanya boleh berisi angka.',
                'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
                'shipping_address.string' => 'Alamat pengiriman harus berupa teks.',
                'shipping_address.max' => 'Alamat pengiriman tidak boleh lebih dari 500 karakter.',
                'province_name.required' => 'Nama provinsi wajib diisi (error internal).',
                'regency_name.required' => 'Nama kabupaten/kota wajib diisi (error internal).',
                'district_name.required' => 'Nama kecamatan wajib diisi (error internal).',
                'village_name.required' => 'Nama kelurahan wajib diisi (error internal).',
            ]);
        } catch (ValidationException $e) {
            // Return validation errors as JSON
            return response()->json(['errors' => $e->errors()], 422);
        }

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

            $fullShippingAddress = $request->input('shipping_address') . ', ' .
                                   $request->input('village_name') . ', ' .
                                   $request->input('district_name') . ', ' .
                                   $request->input('regency_name') . ', ' .
                                   $request->input('province_name');

            // 2. Save Order Details
            $order = Order::create([
                'buyer_name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'phone_number' => $request->input('phone_number'),
                'email' => $request->input('email'),
                'trophy_id' => $trophyID,
                'isCustomize' => $selectedProduct['isCustomize'] ?? false,
                'customize_id' => $selectedProduct['customize_id'] ?? null,
                'shipping_address' => $fullShippingAddress,
                'village_name' => $request->input('village_name'),
                'district_name' => $request->input('district_name'),
                'regency_name'=> $request->input('regency_name'),
                'province_name'=> $request->input('province_name'),
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
                    'address'       => $fullShippingAddress, // Full address string sent to Midtrans
                    'city'          => $request->input('regency_name'), // Use regency name as city for Midtrans
                    'postal_code'   => '12345', // Consider adding this field to your form
                    'country_code'  => 'IDN',
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
            // Log the error for debugging purposes
            \Log::error('Checkout process failed: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memproses checkout. Silakan coba lagi.'], 500);
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

        $orderId = $notification->order_id; // This is the invoice_number we sent to Midtrans
        $serverKey = config('midtrans.server_key');
        $statusCode = $notification->status_code;
        $grossAmount = $notification->gross_amount;
        $signature = $notification->signature_key;

        $mySignatureKey = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signature !== $mySignatureKey) {
            return response('Invalid signature', 403); // Tolak akses jika signature tidak valid
        }

        $midtransTransactionId = $notification->transaction_id; // Midtrans's unique transaction ID
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        // Find the invoice using the orderId (which is our invoice_number)
        $invoice = Invoice::where('invoice_number', $orderId)->first();

        if (!$invoice) {
            // Log error: Invoice not found
            \Log::error("Midtrans Notification: Invoice not found for order_id: " . $orderId);
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
            \Log::error('Error updating invoice status from Midtrans notification: ' . $e->getMessage());
            return response('Error updating invoice status: ' . $e->getMessage(), 500);
        }
    }
}