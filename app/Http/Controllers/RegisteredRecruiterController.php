<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisteredRecruiterController extends Controller
{
    public function create()
    {
        return view("auth.register-recruiter");
    }

    public function store(Request $request)
    {
        // Validate user attributes
        $userAttributes = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

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

            // Create the user with the 'recruiter' role
            $userAttributes['role'] = 'recruiter';
            $userAttributes['password'] = bcrypt($userAttributes['password']);
            $user = User::create($userAttributes);

            // Create the company associated with the user
            $user->company()->create([
                'name' => $companyAttributes['company'],
                'logo' => $logoPath,
                'profile' => $companyAttributes['profile'],
                'city' => $companyAttributes['city'],
                'state' => $companyAttributes['state'],
                'founded' => $companyAttributes['founded'],
                'website' => $companyAttributes['website'],
            ]);

            DB::commit();

            Auth::login($user);

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
}
