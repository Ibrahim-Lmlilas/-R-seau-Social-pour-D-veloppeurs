<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'nullable|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'experience_level' => 'nullable|string|max:255',
            'skills_required' => 'nullable|string',
            'application_url' => 'nullable|url|max:255',
            'deadline' => 'nullable|date',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_active'] = true;

        Job::create($validated);

        return redirect()->route('jobs.index')
            ->with('success', 'Job offer posted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        // Check if the user is authorized to edit this job
        if (Auth::id() !== $job->user_id) {
            return redirect()->route('jobs.index')
                ->with('error', 'You are not authorized to edit this job offer.');
        }

        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        // Check if the user is authorized to update this job
        if (Auth::id() !== $job->user_id) {
            return redirect()->route('jobs.index')
                ->with('error', 'You are not authorized to update this job offer.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'nullable|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'experience_level' => 'nullable|string|max:255',
            'skills_required' => 'nullable|string',
            'application_url' => 'nullable|url|max:255',
            'deadline' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $job->update($validated);

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Job offer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        // Check if the user is authorized to delete this job
        if (Auth::id() !== $job->user_id) {
            return redirect()->route('jobs.index')
                ->with('error', 'You are not authorized to delete this job offer.');
        }

        $job->delete();

        return redirect()->route('jobs.index')
            ->with('success', 'Job offer deleted successfully!');
    }

    // Dans votre JobController, ajoutez une méthode pour récupérer les offres d'emploi récentes

    public function getRecentJobs()
    {
        $recentJobs = Job::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return $recentJobs;
    }
}
