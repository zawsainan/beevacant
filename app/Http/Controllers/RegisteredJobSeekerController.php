<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class RegisteredJobSeekerController extends Controller
{
    public function create()
    {
        return view("auth.register-job-seeker");
    }
    public function store(Request $request)
    {
        $request->merge([
            'skills' => array_filter(array_map('trim', explode(",", $request['skills'])))
        ]);

        // Validate user attributes
        $userAttributes = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        // Validate work profile attributes
        $workProfileAttributes = $request->validate([
            'experience_level' => ['required', Rule::in(['Entry', 'Mid', 'Senior'])],
            'expected_salary' => ['nullable', 'integer'],
            'overview' => ['required'],
            'skills' => ['required', 'array'],
            'skills.*' => ['string'],
            'profile_picture' => ['nullable', 'mimes:jpg,png,webp,svg'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'profession' => ['required'],
            'phone_number' => ['required']
        ]);
        DB::beginTransaction();
        try {

            // Store the profile picture
            $imagePath = $request->hasFile('profile_picture')
                ? $request->profile_picture->store('profile-pictures', 'public')
                : null;
            // Create the user with the 'job_seeker' role
            $userAttributes['role'] = 'job_seeker';
            $userAttributes['password'] = bcrypt($userAttributes['password']);

            $user = User::create($userAttributes);


            // Create the work profile associated with the user
            $user->work_profile()->create(array_merge($workProfileAttributes, ['profile_picture' => $imagePath]));

            // Commit the transaction
            DB::commit();

            Auth::login($user);
            return redirect()->route('home');
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();

            //Logging the error for debugging purposes
            Log::error($e->getMessage(), ['exception' => $e]);

            return redirect()->back()->with([
                'error' => 'Something went wrong. Please try again'
            ]);
        }
    }
}
