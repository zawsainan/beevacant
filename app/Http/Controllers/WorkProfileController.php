<?php

namespace App\Http\Controllers;

use App\Models\WorkProfile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WorkProfileController extends Controller
{
    public function index(Request $request)
    {
        if (in_array($request->user()->role, ['admin', 'recruiter'])) {
            return WorkProfile::paginate(10);
        }
        return response()->json([
            'message' => 'Only Admins and recruiters can view all work profiles'
        ], 403);
    }

    public function view($id)
    {
        $profile = WorkProfile::find($id);
        if (!$profile) {
            return response()->json([
                'message' => "Profile Not found"
            ], 404);
        }
        return response()->json([
            'profile' => $profile
        ], 200);
    }

    public function show(Request $request)
    {
        $profile = $request->user()->workprofile;
        if (!$profile) {
            return response()->json([
                'message' => "Profile Not found"
            ], 404);
        }
        return response()->json([
            'profile' => $profile
        ], 200);
    }

    public function update(Request $request)
    {
        $attributes = $request->validate([
            'experience_level' => ['required', Rule::in(['Entry', 'Mid', 'Senior'])],
            'expected_salary' => ['nullable', 'integer'],
            'overview' => ['required'],
            'skills' => ['required', 'array'],
            'profile_picture' => ['nullable', 'mimes:jpg,png,webp,svg', 'max:2048'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'profession' => ['required'],
            'phone_number' => ['required']
        ]);
        if ($request->hasFile('profile_picture')) {
            $attributes['profile_picture'] = $request->profile_picture->store('profile-pictures');
        }
        $request->user()->workprofile->update($attributes);
        return response()->json([
            'message' => 'Profile Updated Successfully.'
        ], 200);
    }

    public function toggleActivate(Request $request)
    {
        $profile = $request->user()->workprofile;
        if (!$profile) {
            return response()->json([
                'message' => 'Profile Not Found'
            ], 404);
        }
        $profile->is_active = !$profile->is_active;
        $profile->save();
        return response()->json([
            'message' => 'Profile ' . ($profile->is_active ? 'activate' : 'deactivate')  . ' successfully.'
        ], 200);
    }
}
