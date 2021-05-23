<?php

namespace App\Http\Controllers;

use App\Http\Enums\HttpResponseStatus;
use App\Http\Requests\InvoiceRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Throwable;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|ResponseFactory|Response
     */
    public function index()
    {
        $order = Order::with(['jobPost', 'discount', 'createdBy', 'updatedBy', 'status'])
            ->orderByDesc('created_at')->paginate(10);

        return response(new OrderCollection($order), HttpResponseStatus::OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderRequest $request
     * @return Response
     */
    public function store(OrderRequest $request)
    {
        Order::create(array_merge(['created_by' => \Auth::id()], $request->all()));

        return response(null, HttpResponseStatus::CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Order  $order
     * @return Response
     */
    public function show(Order $order)
    {
        $orderWithRelations = Order::with(['jobPost', 'discount', 'createdBy', 'updatedBy', 'status'])
            ->find($order->id);

        return response(new OrderResource($orderWithRelations), HttpResponseStatus::OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderRequest $request
     * @param Order $order
     * @return Response
     * @throws Throwable
     */
    public function update(OrderRequest $request, Order $order)
    {
        $order->fill(array_merge(['updated_by' => \Auth::id()], $request->all()))->saveOrFail();

        return response(null, HttpResponseStatus::NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order  $order
     * @return Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response(null, HttpResponseStatus::NO_CONTENT);
    }
}
