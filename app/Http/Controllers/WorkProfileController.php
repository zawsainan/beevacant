<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class WorkProfileController extends Controller
{
    public function index()
    {
        return view("profiles.job_seeker_profile");
    }

    public function edit()
    {
        return view("profiles.edit_job_seeker_profile");
    }

    public function update(Request $request)
    {
        $userAttributes = $request->validate([
            'name' => 'required'
        ]);

        $workProfileAttributes = $request->validate([
            'experience_level' => ['required', Rule::in(['Entry', 'Mid', 'Senior'])],
            'expected_salary' => ['nullable'],
            'overview' => ['required'],
            'skills' => ['required'],
            'profile_picture' => ['nullable', 'mimes:jpg,png,webp,svg'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'profession' => ['required'],
            'phone_number' => ['required']
        ]);
        DB::beginTransaction();
        try {

            $imagePath = $request->hasFile('profile_picture')
                ? $request->profile_picture->store('profile-pictures', 'public')
                : null;

            $user = Auth::user();
            $user->update($userAttributes);

            $workProfileAttributes['skills'] = array_filter(array_map("trim", explode(",", $workProfileAttributes['skills'])));
            $workProfileAttributes['profile_picture'] = $imagePath;
            $user->work_profile->update($workProfileAttributes);

            DB::commit();

            Auth::login($user);
            return redirect()->route('home');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage(), ['exception' => $e]);

            return redirect()->back()->with([
                'error' => 'Something went wrong. Please try again'
            ]);
        }
    }
}
