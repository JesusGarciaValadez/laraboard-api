<?php

namespace App\Http\Controllers;

use App\Http\Enums\HttpResponseStatus;
use App\Http\Resources\InvoiceStatusCollection;
use App\Models\InvoiceStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceStatusController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return response(new InvoiceStatusCollection(InvoiceStatus::all()), HttpResponseStatus::OK);
    }
}
