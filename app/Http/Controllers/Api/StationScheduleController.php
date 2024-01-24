<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StationSchedules;
use Illuminate\Http\Request;

class StationScheduleController extends Controller
{
    public function getAllStationSchedules()
    {

        $stationSchedules = StationSchedules::all();
        if ($stationSchedules->count() > 0) {

            return response()->json([
                'status' => 200,
                "stationSchedules" => $stationSchedules,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "stationSchedules" => 'No station Schedules found',
            ], 404);
        }
    }
    public function getStationScheduleById($id)
    {

        $stationSchedule = StationSchedules::find($id);
        if ($stationSchedule) {

            return response()->json([
                'status' => 200,
                "stationSchedule" => $stationSchedule,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "stationSchedules" => 'No station Schedule found',
            ], 404);
        }
    }

    public function createStationSchedule(Request $request)
    {
        $request->validate([
            "station_id"=>'required',
            "user_id"=>'required',

        ]);
        $stationSchedule = StationSchedules::create([
            "status" => "ACTIVE",
            "user_id" => $request->user_id,
            "station_id" => $request->station_id,
            "created_by" => $request->user()->id
        ]);
        if ($stationSchedule->count() > 0) {

            return response()->json([
                'status' => 200,
                'data'=>$stationSchedule,
                "message" => "Station Schedule created successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                "message" => 'Something went wrong',
            ], 500);
        }
    }
    public function updateStationSchedule(Request $request)
    {
        $request->validate([
            "status" => 'required|string'
        ]);
        $stationSchedule = StationSchedules::where('stationSchedule', $request->stationSchedule)->first();
        if ($stationSchedule) {
            $stationSchedule->update([
                "status" => $request->status,
            ]);
            return response()->json([
                'status' => 200,
                "message" => "Station Schedule updated successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "message" => 'No station Schedule found.',
            ], 404);
        }
    }
    public function deleteStationSchedule(int $id)
    {
        $stationSchedule = StationSchedules::find($id);

        if ($stationSchedule) {
            $stationSchedule->delete();
            return response()->json([
                'status' => 200,
                "message" => "Station Schedule deleted successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "message" => 'No station Schedule found with this id '.$id,
            ], 404);
        }
    }
}
