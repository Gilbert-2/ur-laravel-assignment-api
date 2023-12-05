<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Individuals;
use Illuminate\Http\Request;

class IndividualController extends Controller
{
    public function getAllIndividuals()
    {

        $individual = Individuals::all();
        if ($individual->count() > 0) {

            return response()->json([
                'status' => 200,
                "Individual" => $individual,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "Individual" => 'No Individuals found',
            ], 404);
        }
    }
    public function getIndividualById($id)
    {

        $individual = Individuals::find($id);
        if ($individual) {

            return response()->json([
                'status' => 200,
                "Individual" => $Individual,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "Individuals" => 'No Individual found',
            ], 404);
        }
    }

    public function createIndividual(Request $request)
    {
        $request->validate([
            "name" => 'required|string|max:256',
            "address" => 'required|string:128',
            "tel" => 'required|digits:10',
            "email" => 'required|string'
        ]);
        $individual = Individuals::create([
            "name" => $request->name,
            "address" => $request->address,
            "tel" => $request->tel,
            "email" => $request->email
        ]);
        if ($individual->count() > 0) {

            return response()->json([
                'status' => 200,
                "message" => "Individual created successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                "message" => 'Something went wrong',
            ], 500);
        }
    }
    public function updateIndividuals(Request $request, int $id)
    {
        $request->validate([
            "name" => 'required|string|max:256',
            "address" => 'required|string',
            "tel" => 'required|digits:10',
            "email" => 'required|string'
        ]);
        $individual = Individuals::find($id);

        if ($individual) {
            $individual->update([
                "name" => $request->name,
                "address" => $request->address,
                "tel" => $request->tel,
                "email" => $request->email
            ]);
            return response()->json([
                'status' => 200,
                "message" => "Individual updated successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "message" => 'No Individual found with that id',
            ], 404);
        }
    }
    public function deleteIndividuals(int $id)
    {
        $individual = Individual::find($id);

        if ($individual) {
            $individual->delete();
            return response()->json([
                'status' => 200,
                "message" => "Individual deleted successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "message" => 'No Individual found with that id',
            ], 404);
        }
    }
}
