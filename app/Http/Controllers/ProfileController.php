<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile editing form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $request->user()->photo = $path;
        }

        if ($request->has('phone_number')) {
            $request->user()->phone_number = $request->input('phone_number');
        }

        if ($request->has('technical_skills')) {
            $request->user()->technical_skills = $request->input('technical_skills');
        }

        if ($request->has('bio')) {
            $request->user()->bio = $request->input('bio');
        }

        if ($request->has('completed_projects')) {
            $request->user()->completed_projects = $request->input('completed_projects');
        }

        if ($request->has('certifications')) {
            $request->user()->certifications = $request->input('certifications');
        }

        if ($request->has('github_link')) {
            $request->user()->github_link = $request->input('github_link');
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

         $request->user()->save();

        return Redirect::route('profile.edit');
    }

     /**
     * Delete the user's account.
     */
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
