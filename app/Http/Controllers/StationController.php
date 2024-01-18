<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function getAllStations()
    {

        $stations = Station::all();
        if ($stations->count() > 0) {

            return response()->json([
                'status' => 200,
                "stations" => $stations,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "stations" => 'No Stations found',
            ], 404);
        }
    }
    public function getStationById($id)
    {

        $station = Station::find($id);
        if ($station) {

            return response()->json([
                'status' => 200,
                "station" => $station,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "station" => 'No Station found',
            ], 404);
        }
    }

    public function createStation(Request $request)
    {
        $request->validate([
            "name" => 'required|string|max:256',
            "address" => 'required|string:128',
            "email" => 'required|string'
        ]);
        $station = Station::create([
            "name" => $request->name,
            "address" => $request->address,
            "email" => $request->email
        ]);
        if ($station->count() > 0) {

            return response()->json([
                'status' => 200,
                "message" => "Station created successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                "message" => 'Something went wrong',
            ], 500);
        }
    }
    public function updateStation(Request $request, int $id)
    {
        $request->validate([
            "name" => 'required|string|max:256',
            "address" => 'required|string',
            "email" => 'required|string'
        ]);
        $station = Station::find($id);

        if ($station) {
            $station->update([
                "name" => $request->name,
                "address" => $request->address,
                "email" => $request->email
            ]);
            return response()->json([
                'status' => 200,
                "message" => "Station updated successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "message" => 'No Station found with that id',
            ], 404);
        }
    }
    public function deleteStation(int $id)
    {
        $station = Station::find($id);

        if ($station) {
            $station->delete();
            return response()->json([
                'status' => 200,
                "message" => "Station deleted successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "message" => 'No Station found with this id '.$id,
            ], 404);
        }
    }
}
