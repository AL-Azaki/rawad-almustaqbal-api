<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ProjectService;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Traits\ApiResponse;

class ProjectController extends Controller
{
    use ApiResponse;

    public function __construct(private ProjectService $projectService)
    {
    }

    public function index()
    {
        $perPage = config('settings.pagination.default', 15);
        $projects = Project::orderBy('created_at', 'desc')->paginate($perPage);
        
        return $this->successPaginated($projects, ProjectResource::class, 'Projects retrieved successfully');
    }

    public function show($idOrSlug)
    {
        $project = Project::where('slug', $idOrSlug)
            ->orWhere('id', is_numeric($idOrSlug) ? $idOrSlug : 0)
            ->firstOrFail();

        return $this->success(ProjectResource::make($project), 'Project retrieved successfully');
    }

    public function store(StoreProjectRequest $request)
    {
        $project = $this->projectService->createProject(
            $request->validated(),
            $request->file('image'),
            $request->file('before_image'),
            $request->file('after_image'),
            $request->file('video')
        );

        return $this->success(ProjectResource::make($project), 'Project created successfully', 201);
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        $project = Project::findOrFail($id);
        
        $project = $this->projectService->updateProject(
            $project,
            $request->validated(),
            $request->file('image'),
            $request->file('before_image'),
            $request->file('after_image'),
            $request->file('video')
        );

        return $this->success(ProjectResource::make($project), 'Project updated successfully');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $this->projectService->deleteProject($project);
        
        return $this->success(null, 'Project deleted successfully');
    }
}
