<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Qrcode;
use App\Models\StationSchedules;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            "amount" => 'required'
        ]);
        $qrcode = Qrcode::create([
            "qrcode" => Str::random(50),
            "status" => "VALID",
            "plate_number" => "RAB111F",
            "driver_id" => $request->user()->id,
            "station_id" => $request->station_id,
            "amount" => $request->amount,
            "created_by" => $request->user()->id
        ]);
        if ($qrcode->count() > 0) {

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
                "status" => "INVALID",
                 "user_id" => $request->user()->id,
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
