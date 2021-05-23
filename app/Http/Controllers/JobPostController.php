<?php

namespace App\Http\Controllers;

use App\Http\Enums\HttpResponseStatus;
use App\Http\Requests\JobPostRequest;
use App\Http\Resources\JobPostCollection;
use App\Http\Resources\JobPostResource;
use App\Models\JobPost;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Throwable;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|ResponseFactory|Response
     */
    public function index()
    {
        $jobPost = JobPost::orderByDesc('created_at')->paginate();

        return response(new JobPostCollection($jobPost), HttpResponseStatus::OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param JobPostRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function store(JobPostRequest $request)
    {
        JobPost::create(array_merge([
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
            'logo_url' => storeLogo($request),
        ], $request->all()));

        return response(null, HttpResponseStatus::CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param JobPost $jobPost
     * @return Application|ResponseFactory|Response
     */
    public function show(JobPost $jobPost)
    {
        return response(new JobPostResource($jobPost), HttpResponseStatus::OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param JobPostRequest $request
     * @param JobPost $jobPost
     * @return Application|ResponseFactory|Response
     * @throws Throwable
     */
    public function update(JobPostRequest $request, JobPost $jobPost)
    {
        $jobPost->fill(array_merge([
            'updated_by' => Auth::id(),
            'logo_url' => empty($request->logo) ? $jobPost->logo_url : storeLogo($request),
        ], $request->all()))->saveOrFail();

        return response(null, HttpResponseStatus::NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param JobPost $jobPost
     * @return Application|ResponseFactory|Response
     */
    public function destroy(JobPost $jobPost)
    {
        $jobPost->delete();

        return response(null, HttpResponseStatus::NO_CONTENT);
    }
}
