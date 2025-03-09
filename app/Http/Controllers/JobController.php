<?php

namespace App\Http\Controllers;

use App\Services\JobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    protected $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function index()
    {
        // No authentication required for listing jobs
        $jobs = $this->jobService->getAllJobs();
        return response()->json($jobs);
    }

    public function store(Request $request)
    {
        // Only employers can create jobs
        if (Auth::user()->role !== 'employer') {
            return response()->json(['message' => 'Unauthorized. Only employers can create jobs.'], 403);
        }

        // Validate the request data
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'company_name' => 'required|string',
            'salary_range' => 'required|string',
            'location' => 'required|string',
        ]);

        // Add the authenticated user's ID to the data
        $data['user_id'] = Auth::id();

        // Create the job
        $job = $this->jobService->createJob($data);
        return response()->json($job, 201);
    }

    public function show($id)
    {
        // No authentication required for viewing a single job
        $job = $this->jobService->getJobById($id);
        return response()->json($job);
    }

    public function update(Request $request, $id)
    {
        // Only employers can update jobs
        if (Auth::user()->role !== 'employer') {
            return response()->json(['message' => 'Unauthorized. Only employers can update jobs.'], 403);
        }

        // Validate the request data
        $data = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'company_name' => 'sometimes|string',
            'salary_range' => 'sometimes|string',
            'location' => 'sometimes|string',
        ]);

        // Update the job
        $job = $this->jobService->updateJob($id, $data);
        return response()->json($job);
    }

    public function destroy($id)
    {
        // Only employers can delete jobs
        if (Auth::user()->role !== 'employer') {
            return response()->json(['message' => 'Unauthorized. Only employers can delete jobs.'], 403);
        }

        // Delete the job
        $this->jobService->deleteJob($id);
        return response()->json(['message' => 'Job deleted successfully.'], 200);
    }
}