<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PaymentCallbackController extends Controller
{
    /**
     * Menangani callback dari Midtrans setelah pembayaran.
     */
    public function handle(Request $request)
    {
        // Ambil data dari query string
        $statusCode = $request->query('status_code');
        $transactionStatus = $request->query('transaction_status');
        $orderId = $request->query('order_id');

        // Logika untuk menentukan apakah pembayaran sukses atau tidak
        // Pembayaran dianggap sukses jika status code 200 dan status transaksi 'settlement'
        if ($statusCode == '200' && $transactionStatus == 'settlement') {
            
            // TODO: Tambahkan logika untuk update status order di database Anda di sini
            // Contoh: Order::where('id', $orderId)->update(['status' => 'paid']);

            return view('pages.payment.success', [
                'orderId' => $orderId
            ]);

        } else {
            
            // TODO: Tambahkan logika untuk menangani order yang gagal/pending di sini
            // Contoh: Order::where('id', $orderId)->update(['status' => 'failed']);

            return view('pages.payment.failed', [
                'orderId' => $orderId,
                'status' => $transactionStatus // 'deny', 'expire', 'cancel', dll.
            ]);
        }
    }
}