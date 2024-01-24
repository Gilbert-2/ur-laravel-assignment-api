<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function getAllWallets()
    {

        $wallets = Wallet::all();
        if ($wallets->count() > 0) {

            return response()->json([
                'status' => 200,
                "wallets" => $wallets,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "wallets" => 'No wallets found',
            ], 404);
        }
    }
    public function getWalletById($id)
    {

        $wallet = Wallet::find($id);
        if ($wallet) {

            return response()->json([
                'status' => 200,
                "wallet" => $wallet,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "wallets" => 'No wallet found',
            ], 404);
        }
    }

    public function createWallet(Request $request)
    {
        $request->validate([
            "station_id" => 'required'
        ]);
        $wallet = Wallet::create([
            "balance" => 0,
            "user_id" => $request->user()->id,
            "station_id" => $request->station_id,
            "created_by" => $request->user()->id
        ]);
        if ($wallet->count() > 0) {

            return response()->json([
                'status' => 200,
                'data'=>$wallet,
                "message" => "Wallet created successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                "message" => 'Something went wrong',
            ], 500);
        }
    }
    public function updateWallet(Request $request,$id)
    {
        $request->validate([
            "balance" => 'required|integer|min:0'

        ]);
        $wallet = Wallet::where('id', $id)->first();

        if ($wallet) {
            $wallet->update([
                "balance" =>$request->balance,
            ]);
            return response()->json([
                'status' => 200,
                "message" => "Wallet updated successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "message" => 'No wallet found.',
            ], 404);
        }
    }
    public function deleteWallet(int $id)
    {
        $wallet = Wallet::find($id);

        if ($wallet) {
            $wallet->delete();
            return response()->json([
                'status' => 200,
                "message" => "Wallet deleted successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "message" => 'No wallet found with that id '.$id,
            ], 404);
        }
    }
}
