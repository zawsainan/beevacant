<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function recruiterRegister(Request $request)
    {
        DB::beginTransaction();

        try {
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
                'profile' => ['required']
            ]);

            // Store logo and get its path
            $logoPath = $companyAttributes['logo']->store('logos');

            // Create the user with the 'recruiter' role
            $userAttributes['role'] = 'recruiter';
            $userAttributes['password'] = bcrypt($userAttributes['password']);
            $user = User::create($userAttributes);

            // Create the company associated with the user
            $user->company()->create([
                'name' => $companyAttributes['company'],
                'logo' => $logoPath,
                'profile' => $companyAttributes['profile']
            ]);

            DB::commit();

            // Create the API token for the user
            $token = $user->createToken($request->name ?? 'JobPlatformToken');

            return [
                'user' => $user,
                'token' => $token->plainTextToken
            ];
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();
            //Log the error for debugging purposes
            Log::error($e->getMessage(), ['exception' => $e]);
            return $e->getMessage();
        }
    }


    public function jobSeekerRegister(Request $request)
    {
        DB::beginTransaction();
        try {
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
                'profile_picture' => ['required', 'mimes:jpg,png,webp,svg'],
                'birthday' => ['required', 'date_format:Y-m-d'],
                'profession' => ['required'],
                'phone_number' => ['required']
            ]);

            // Store the profile picture
            $imagePath = $request->profile_picture->store('profile-pictures');

            // Create the user with the 'job_seeker' role
            $userAttributes['role'] = 'job_seeker';
            $userAttributes['password'] = bcrypt($userAttributes['password']);

            $user = User::create($userAttributes);

            $workProfileAttributes['skills'] = json_encode($workProfileAttributes['skills']);

            // Create the work profile associated with the user
            $user->workProfile()->create(array_merge($workProfileAttributes, ['profile_picture' => $imagePath]));

            // Commit the transaction
            DB::commit();

            // Generate a token for the user
            $token = $user->createToken($request->name ?? 'JobPlatformToken');

            return [
                'user' => $user,
                'work profile' => $user->workprofile,
                'token' => $token->plainTextToken
            ];
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();

            //Logging the error for debugging purposes
            Log::error($e->getMessage(), ['exception' => $e]);

            return $e->getMessage();
        }
    }

    public function login(Request $request)
    {
        //Validate User Attributes
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        //Retrieving User with Provided Credentials
        $user = User::where('email', $request->email)->first();

        //Check if User exists or if Password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Sorry, the provided credentials are incorrect'
            ], 401);
        }
        //Create token
        $token = $user->createToken($request->name ?? 'JobPlatformToken');
        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }
    public function logout(Request $request)
    {
        //Delete Tokens of Current User
        $request->user()->tokens()->delete();
        return [
            'message' => 'You are logged out.'
        ];
    }
}
