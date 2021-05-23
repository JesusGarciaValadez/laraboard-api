<?php

namespace App\Http\Controllers;

use App\Http\Enums\HttpResponseStatus;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response(new UserCollection(User::all()), HttpResponseStatus::OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        User::create($request->all());

        return response(null, HttpResponseStatus::CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return Response
     */
    public function show(User $user)
    {
        return response(new UserResource($user), HttpResponseStatus::OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return Response
     * @throws Throwable
     */
    public function update(UserRequest $request, User $user)
    {
        $user->fill($request->all())->saveOrFail();

        return response(null, HttpResponseStatus::NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response(null, HttpResponseStatus::NO_CONTENT);
    }
}
