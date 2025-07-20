<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Qrcode;
use App\Models\StationSchedules;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Transaction;

/**
 * QR code status values:
 * - PENDING: Created, waiting for driver confirmation
 * - COMPLETED: Transaction done, QR code used
 * - EXPIRED: (optional) QR code expired, not used
 */
class QrcodeController extends Controller
{
    public function getAllQrcodes()
    {

        $qrcodes = Qrcode::all();
        if ($qrcodes->count() > 0) {

            return response()->json([
                'status' => 200,
                "qrcodes" => $qrcodes,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "qrcodes" => 'No qrcodes found',
            ], 404);
        }
    }
    public function getQrcodeById($id)
    {

        $qrcode = Qrcode::find($id);
        if ($qrcode) {

            return response()->json([
                'status' => 200,
                "qrcode" => $qrcode,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "qrcodes" => 'No qrcode found',
            ], 404);
        }
    }

    public function createQrcode(Request $request)
    {
        $request->validate([
            "station_id"=>'required',
            "amount" => 'required|numeric'
        ]);
        // Only stations can create QR codes. You may want to add a role check here if available.
        $qrcode = Qrcode::create([
            "qrcode" => Str::random(50),
            "status" => "PENDING",
            "plate_number" => $request->plate_number ?? null, // Optional, or remove if not needed
            "driver_id" => null, // Not assigned at creation
            "station_id" => $request->station_id,
            "amount" => $request->amount,
            "created_by" => $request->user()->id
        ]);
        // Ensure station wallet exists
        $stationWallet = \App\Models\Wallet::where('station_id', $request->station_id)->first();
        if (!$stationWallet) {
            \App\Models\Wallet::create([
                'balance' => 1000000, // For testing; set to 0 for production
                'user_id' => 0,
                'station_id' => $request->station_id,
                'created_by' => $request->user()->id
            ]);
        }
        if ($qrcode) {
            return response()->json([
                'status' => 200,
                'data'=>$qrcode,
                "message" => "Qrcode created successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                "message" => 'Something went wrong',
            ], 500);
        }
    }
    public function updateQrcode(Request $request)
    {
        $request->validate([
            "qrcode" => 'required|string'
        ]);
        $qrcode = Qrcode::where('qrcode', $request->qrcode)->first();
        if ($qrcode->status == "INVALID") {
            return response()->json([
                'status' => 200,
                "message" => "Qrcode already used!",
            ], 200);
        }
        $stationSchedule = StationSchedules::where('user_id', 2)->first();
        if ($stationSchedule->count() < 1) {
            return response()->json([
                'status' => 200,
                "message" => "Not assigned!",
            ], 200);
        }
        if ($stationSchedule->station_id != $qrcode->station_id) {
            return response()->json([
                'status' => 200,
                "message" => "Not assigned!",
            ], 200);
        }
        $walletDetails = Wallet::where('station_id',$qrcode->station_id )->first();
        if($qrcode->amount > $walletDetails->balance){
            return response()->json([
                'status' => 200,
                "message" => "Low balance on the account",
            ], 200);
        }
        $amount=$walletDetails->balance - $qrcode->amount;

         $walletDetails->update([
                "balance" => $amount,
            ]);
        if ($qrcode) {
            $qrcode->update([
                "status" => "INVALID"
            ]);
            return response()->json([
                'status' => 200,
                "message" => "Qrcode verified!",
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "message" => 'No qrcode found.',
            ], 404);
        }
    }
    public function confirmQrcode(Request $request)
    {
        $request->validate([
            'qrcode' => 'required|string',
        ]);
        $qrcode = Qrcode::where('qrcode', $request->qrcode)->first();
        if (!$qrcode) {
            return response()->json([
                'status' => 404,
                'message' => 'QR code not found.',
            ], 404);
        }
        if ($qrcode->status !== 'PENDING') {
            return response()->json([
                'status' => 400,
                'message' => 'QR code is not available for confirmation.',
            ], 400);
        }
        $driver = $request->user();
        // Find driver's wallet
        $driverWallet = \App\Models\Wallet::where('user_id', $driver->id)->first();
        if (!$driverWallet || $driverWallet->balance < $qrcode->amount) {
            return response()->json([
                'status' => 400,
                'message' => 'Insufficient balance in driver wallet.',
            ], 400);
        }
        // Find station's wallet
        $stationWallet = \App\Models\Wallet::where('station_id', $qrcode->station_id)->first();
        if (!$stationWallet) {
            return response()->json([
                'status' => 404,
                'message' => 'Station wallet not found.',
            ], 404);
        }
        // Move money
        $driverWallet->balance -= $qrcode->amount;
        $stationWallet->balance += $qrcode->amount;
        $driverWallet->save();
        $stationWallet->save();
        // Update QR code
        $qrcode->update([
            'status' => 'COMPLETED',
            'driver_id' => $driver->id,
        ]);
        // Record transaction
        $transaction = Transaction::create([
            'wallet_id' => $driverWallet->id,
            'amount' => $qrcode->amount,
            'station_id' => $qrcode->station_id,
            'driver_id' => $driver->id,
            'status' => 'COMPLETED',
            'created_by' => $driver->id,
        ]);
        return response()->json([
            'status' => 200,
            'data' => [
                'amount' => $transaction->amount,
                'plate_number' => $qrcode->plate_number,
                'station_id' => $transaction->station_id,
                'status' => $transaction->status,
            ],
            'message' => 'Qrcode found',
        ], 200);
    }
    public function getQrcodeDetails(Request $request)
    {
        $request->validate([
            'qrcode' => 'required|string',
        ]);
        $qrcode = Qrcode::where('qrcode', $request->qrcode)->first();
        if (!$qrcode) {
            return response()->json([
                'status' => 404,
                'message' => 'QR code not found.',
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => [
                'amount' => $qrcode->amount,
                'plate_number' => $qrcode->plate_number,
                'station_id' => $qrcode->station_id,
                'status' => $qrcode->status,
            ],
            'message' => 'Qrcode details found',
        ], 200);
    }
    public function deleteQrcode(int $id)
    {
        $qrcode = Qrcode::find($id);

        if ($qrcode) {
            $qrcode->delete();
            return response()->json([
                'status' => 200,
                "message" => "Qrcode deleted successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "message" => 'No qrcode found with that id '.$id,
            ], 404);
        }
    }
}
