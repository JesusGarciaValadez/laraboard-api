<?php

namespace App\Http\Controllers;

use App\Http\Enums\HttpResponseStatus;
use App\Http\Resources\OrderStatusCollection;
use App\Models\OrderStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderStatusController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function __invoke(Request $request)
    {
        return response(new OrderStatusCollection(OrderStatus::all()), HttpResponseStatus::OK);
    }
}
