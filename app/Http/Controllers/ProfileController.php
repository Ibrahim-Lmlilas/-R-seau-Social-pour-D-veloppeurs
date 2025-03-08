<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }




    public function update(ProfileUpdateRequest $request)
        {
            $user = $request->user();
            $validated = $request->validated();

            // Remove array fields from validated data to handle separately
            if (isset($validated['skills'])) {
                $skills = $validated['skills'];
                unset($validated['skills']);
            }

            if (isset($validated['programming_languages'])) {
                $programming_languages = $validated['programming_languages'];
                unset($validated['programming_languages']);
            }

            if (isset($validated['projects'])) {
                $projects = $validated['projects'];
                unset($validated['projects']);
            }

            if (isset($validated['certifications'])) {
                $certifications = $validated['certifications'];
                unset($validated['certifications']);
            }

            // Fill user with non-array validated data
            $user->fill($validated);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            // Handle skills array
            if (isset($skills)) {
                // Filter out empty values and join with commas
                $user->skills = implode(',', array_filter($skills, function($value) {
                    return !empty(trim($value));
                }));
            }

            // Handle programming languages array
            if (isset($programming_languages)) {
                // Filter out empty values and join with commas
                $user->programming_languages = implode(',', array_filter($programming_languages, function($value) {
                    return !empty(trim($value));
                }));
            }

            // Handle projects array
            if (isset($projects)) {
                // Filter out empty values and join with commas
                $user->projects = implode(',', array_filter($projects, function($value) {
                    return !empty(trim($value));
                }));
            }

            // Handle certifications array
            if (isset($certifications)) {
                // Filter out empty values and join with commas
                $user->certifications = implode(',', array_filter($certifications, function($value) {
                    return !empty(trim($value));
                }));
            }

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($user->image) {
                    Storage::disk('public')->delete($user->image);
                }
                $imagePath = $request->file('image')->store('profile-images', 'public');
                $user->image = $imagePath;
            }

            // Handle banner upload
            if ($request->hasFile('banner')) {
                // Delete old banner if exists
                if ($user->banner) {
                    Storage::disk('public')->delete($user->banner);
                }
                $bannerPath = $request->file('banner')->store('banner-images', 'public');
                $user->banner = $bannerPath;
            }

            $user->save();

            // Redirect to dashboard instead of profile edit page
            return Redirect::route('dashboard')->with('status', 'profile-updated');
        }


    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
