<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role == "admin") {
            return response()->json([
                'companies' => Company::all()
            ], 200);
        }
        return response()->json([
            'message' => 'Unauthorized. Only admin can retrieve all companies'
        ], 403);
    }

    public function show(Request $request)
    {
        if ($request->user()->role != 'recruiter') {
            return response()->json([
                'message' => 'Unauthorized. Only recruiters can view their company profile.'
            ], 403);
        }
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

    public function store(Request $request)
    {
        if ($request->user()->role != 'recruiter') {
            return response()->json([
                'message' => 'Unauthorized. Only recruiters can have company.'
            ], 403);
        }

        $attributes = $request->validate([
            'company' => ['required', 'max:255'],
            'logo' => ['required', 'mimes:jpg,png,webp,svg'],
            'profile' => ['required']
        ]);

        $request->user()->company()->create($attributes);

        return response()->json([
            'message' => 'Company profile created successfully.'
        ], 201);
    }

    public function update(Request $request)
    {
        if ($request->user()->role != 'recruiter') {
            return response()->json([
                'message' => 'Unauthorize. Only recruiters can modify company details.'
            ], 403);
        }

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
        if ($request->user()->role != 'recruiter') {
            return response()->json([
                'message' => 'Unauthorize. Only recruiters can delete their company profile.'
            ], 403);
        }
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
