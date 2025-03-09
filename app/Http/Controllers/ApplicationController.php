<?php

namespace App\Http\Controllers;

use App\Services\ApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    protected $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function index()
    {
        // Only employers can view all applications
        if (Auth::user()->role !== 'employer') {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $applications = $this->applicationService->getAllApplications();
        return response()->json($applications);
    }

    public function store(Request $request)
    {
        // Only job seekers can apply for jobs
        if (Auth::user()->role !== 'job_seeker') {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $data = $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'cover_letter' => 'required|string',
        ]);

        // Add the authenticated user's ID to the data
        $data['user_id'] = Auth::id();

        $application = $this->applicationService->createApplication($data);
        return response()->json($application, 201);
    }

    public function show($id)
    {
        $application = $this->applicationService->getApplicationById($id);

        // Only the applicant or the employer can view the application
        if (Auth::user()->role !== 'employer' && Auth::id() !== $application->user_id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        return response()->json($application);
    }

    public function update(Request $request, $id)
    {
        // Only employers can update application status
        if (Auth::user()->role !== 'employer') {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $data = $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
        ]);

        $application = $this->applicationService->updateApplication($id, $data);
        return response()->json($application);
    }

    public function destroy($id)
    {
        // Only the applicant or the employer can delete the application
        $application = $this->applicationService->getApplicationById($id);

        if (Auth::user()->role !== 'employer' && Auth::id() !== $application->user_id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $this->applicationService->deleteApplication($id);
        return response()->json(['message' => 'Application deleted successfully.'], 200);
    }
}
