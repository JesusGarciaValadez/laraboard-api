<?php

namespace App\Http\Controllers;

use App\Http\JobPosts;
use App\Models\JobPost as JobPostsModel;
use Illuminate\Http\Request;

class JobPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(JobPosts $jobPosts)
    {
        return 'pepox';
        return JobPostsModel::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobPost  $jobPosts
     * @return \Illuminate\Http\Response
     */
    public function show(JobPosts $jobPosts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobPost  $jobPosts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobPosts $jobPosts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobPost  $jobPosts
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobPosts $jobPosts)
    {
        //
    }
}
