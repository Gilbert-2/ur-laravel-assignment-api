<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function getAllEmployees()
    {

        $employees = Employee::all();
        if ($employees->count() > 0) {

            return response()->json([
                'status' => 200,
                "employees" => $employees,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "employees" => 'No employees found',
            ], 404);
        }
    }
    public function getEmployeeById($id)
    {

        $employee = Employee::find($id);
        if ($employee) {

            return response()->json([
                'status' => 200,
                "employee" => $employee,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "employees" => 'No employee found',
            ], 404);
        }
    }

    public function createEmployee(Request $request)
    {
        $request->validate([
            "name" => 'required|string|max:256',
            "address" => 'required|string:128',
            "tel" => 'required|digits:10',
            "email" => 'required|string'
        ]);
        $employees = Employee::create([
            "name" => $request->name,
            "address" => $request->address,
            "tel" => $request->tel,
            "email" => $request->email
        ]);
        if ($employees->count() > 0) {

            return response()->json([
                'status' => 200,
                "message" => "Employee created successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                "message" => 'Something went wrong',
            ], 500);
        }
    }
    public function updateEmployee(Request $request, int $id)
    {
        $request->validate([
            "name" => 'required|string|max:256',
            "address" => 'required|string',
            "tel" => 'required|digits:10',
            "email" => 'required|string'
        ]);
        $employee = Employee::find($id);

        if ($employee) {
            $employee->update([
                "name" => $request->name,
                "address" => $request->address,
                "tel" => $request->tel,
                "email" => $request->email
            ]);
            return response()->json([
                'status' => 200,
                "message" => "Employee updated successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "message" => 'No employee found with that id',
            ], 404);
        }
    }
    public function deleteEmployee(int $id)
    {
        $employee = Employee::find($id);

        if ($employee) {
            $employee->delete();
            return response()->json([
                'status' => 200,
                "message" => "Employee deleted successfully!",
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                "message" => 'No employee found with that id',
            ], 404);
        }
    }
}
