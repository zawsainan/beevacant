<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function view()
    {
        return view("profiles.recruiter_profile");
    }

    public function index()
    {
        $companies = Company::with('jobs')->paginate(10);
        return view('companies.index', ['companies' => $companies]);
    }

    public function show(Company $company)
    {
        return view("companies.detail", ["company" => $company]);
    }


    public function edit()
    {
        return view("profiles.edit_recruiter_profile");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        // Validate company attributes
        $companyAttributes = $request->validate([
            'company' => ['required', 'max:255'],
            'logo' => ['required', 'mimes:jpg,png,webp,svg'],
            'profile' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'founded' => ['required'],
            'website' => ['required', 'url'],
        ]);
        DB::beginTransaction();

        try {

            // Store logo and get its path
            $logoPath = $companyAttributes['logo']->store('logos', 'public');
            $user = Auth::user();
            // Create the company associated with the user
            $user->company->update([
                'name' => $companyAttributes['company'],
                'logo' => $logoPath,
                'profile' => $companyAttributes['profile'],
                'city' => $companyAttributes['city'],
                'state' => $companyAttributes['state'],
                'founded' => $companyAttributes['founded'],
                'website' => $companyAttributes['website'],
            ]);

            DB::commit();

            return redirect("/");
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();
            //Log the error for debugging purposes
            Log::error($e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with([
                'error' => 'Something went wrong. Please try again'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
