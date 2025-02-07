<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.serverKey');
        $hashedKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashedKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;
        $transaction = Transaction::where('code', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // twilio
        $sid = env('TWILIO_ID');
        $token = env('TWILIO_TOKEN');
        $twilio = new Client($sid, $token);

        $messages =
            "Dear " . $transaction->name . "," . PHP_EOL . PHP_EOL .
            "📋 *Konfirmasi Pembayaran Berhasil*" . PHP_EOL .
            "━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL .
            "*Kode Booking:* " . $transaction->code . PHP_EOL .
            "*Total Pembayaran:* Rp " . number_format($transaction->total_amount, 0, ',', '.') . PHP_EOL . PHP_EOL .
            "📍 *Detail Kos*" . PHP_EOL .
            "━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL .
            "*Nama Kos:* " . $transaction->BoardingHouse->name . PHP_EOL .
            "*Alamat:* " . $transaction->BoardingHouse->address . PHP_EOL .
            "*Check-in:* " . date('d F Y', strtotime($transaction->start_date)) . PHP_EOL . PHP_EOL .
            "ℹ️ *Informasi Penting*" . PHP_EOL .
            "Simpan bukti pembayaran ini sebagai referensi. Silakan tunjukkan saat check-in." . PHP_EOL . PHP_EOL .
            "Terima kasih telah mempercayakan hunian Anda kepada kami. Selamat beristirahat di rumah baru Anda! 🏠" . PHP_EOL . PHP_EOL .
            "Best Regards," . PHP_EOL .
            "Tim " . $transaction->BoardingHouse->name;


        switch ($transactionStatus) {
            case 'capture':
                if ($request->payment_type == 'credit_card') {
                    if ($request->fraud_status == 'challenge') {
                        $transaction->update(['payment_status' => 'pending']);
                    } else {
                        $transaction->update(['payment_status' => 'success']);
                    }
                }
                break;
            case 'settlement':
                $transaction->update(['payment_status' => 'success']);
                try {
                    $message = $twilio->messages->create(
                        "whatsapp:+" . $transaction->phone_number,
                        [
                            "from" => "whatsapp:+14155238886",
                            "body" => $messages
                        ]
                    );
                    \Log::info('Twilio message sent: ' . $message->sid);
                } catch (\Exception $e) {
                    \Log::error('Twilio Error: ' . $e->getMessage());
                }
                break;
            case 'pending':
                $transaction->update(['payment_status' => 'pending']);
                break;
            case 'deny':
                $transaction->update(['payment_status' => 'failed']);
                break;
            case 'expire':
                $transaction->update(['payment_status' => 'expired']);
                break;
            case 'cancel':
                $transaction->update(['payment_status' => 'canceled']);
                break;
            default:
                $transaction->update(['payment_status' => 'unknown']);
                break;
        }

        return response()->json(['message' => 'Callback received successfully']);
    }
}
