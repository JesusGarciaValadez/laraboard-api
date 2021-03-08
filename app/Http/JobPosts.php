<?php


namespace App\Http;

use \App\Models\JobPosts as JobPostsModel;
use Illuminate\Http\Request;

class JobPosts
{
    public function index ()
    {
        return JobPostsModel::all();
    }

    public function store(Request $request)
    {
        //
    }

    public function show(JobPosts $jobPosts)
    {
        //
    }

    public function update(Request $request, JobPosts $jobPosts)
    {
        //
    }

    public function destroy(JobPosts $jobPosts)
    {
        //
    }
}
