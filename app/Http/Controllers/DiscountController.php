<?php

namespace App\Http\Controllers;

use App\Http\Enums\HttpResponseStatus;
use App\Http\Requests\DiscountRequest;
use App\Http\Resources\DiscountCollection;
use App\Http\Resources\DiscountResource;
use App\Models\Discount;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Throwable;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $discount = Discount::orderByDesc('created_at')->paginate(10);

        return response(new DiscountCollection($discount), HttpResponseStatus::OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DiscountRequest $request
     * @return Response
     */
    public function store(DiscountRequest $request)
    {
        Discount::create(array_merge(['created_by' => Auth::id()], $request->all()));

        return response(null, HttpResponseStatus::CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Discount  $discount
     * @return Response
     */
    public function show(Discount $discount)
    {
        return response(new DiscountResource($discount), HttpResponseStatus::OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DiscountRequest $request
     * @param Discount $discount
     * @return Response
     * @throws Throwable
     */
    public function update(DiscountRequest $request, Discount $discount)
    {
        $discount->fill(array_merge(['updated_by' => Auth::id()], $request->all()))->saveOrFail();

        return response(null, HttpResponseStatus::NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Discount  $discount
     * @return Response
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return response(null, HttpResponseStatus::NO_CONTENT);
    }
}
