<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CompanyController extends Controller
{


    public function show(Request $request)
    {
        $company = $request->user()->company;
        if (!$company) {
            return response()->json([
                'message' => 'Company not found.'
            ], 404);
        }

        return response()->json([
            'company' => $company
        ], 200);
    }

    public function update(Request $request)
    {
        $attributes = $request->validate([
            'company' => ['required', 'max:255'],
            'logo' => ['required', 'mimes:jpg,png,webp,svg'],
            'profile' => ['required']
        ]);

        $request->user()->company->update($attributes);

        return response()->json([
            'message' => 'Company profile updated successfully.'
        ], 201);
    }

    public function destroy(Request $request)
    {
        $company = $request->user()->company;
        if (!$company) {
            return response()->json([
                'message' => 'Company not found.'
            ], 404);
        }
        $company->delete();
        return response()->json([
            'message' => "Company profile deleted successfully."
        ], 200);
    }
}
