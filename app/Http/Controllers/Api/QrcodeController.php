<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Qrcode;
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
            "plate_number" => 'required|string|max:6',
            "driver_id" => 'required',
            "user_id" => 'required',
            "station_id"=>'required',
            "amount" => 'required'
        ]);
        $qrcode = Qrcode::create([
            "qrcode" => Str::random(50),
            "status" => "VALID",
            "plate_number" => $request->plate_number,
            "driver_id" => $request->driver_id,
            "user_id" => $request->user_id,
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
    public function updateQrcode(Request $request, int $id)
    {
       
        $request->validate([
            "status" => 'required|string'
        ]);
        $qrcode = Qrcode::find($id);

        if ($qrcode->status == "INVALID") {
            return response()->json([
                'status' => 400,
                "message" => "Qrcode already used!",
            ], 400);
        }
        if ($qrcode) {
            $qrcode->update([
                "status" => $request->status,
            ]);
            return response()->json([
                'status' => 200,
                "message" => "Qrcode updated successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "message" => 'No qrcode found with that id',
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
