<?php

namespace App\Http\Controllers;

use App\Http\Enums\HttpResponseStatus;
use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceCollection;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Throwable;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|ResponseFactory|Response
     */
    public function index()
    {
        $invoice = Invoice::with(['order', 'discount', 'createdBy', 'updatedBy', 'status'])
            ->orderByDesc('created_at')->paginate(10);

        return response(new InvoiceCollection($invoice), HttpResponseStatus::OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InvoiceRequest $request
     * @return Response
     */
    public function store(InvoiceRequest $request)
    {
        Invoice::create(array_merge(['created_by' => \Auth::id()], $request->all()));

        return response(null, HttpResponseStatus::CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Invoice  $invoice
     * @return Response
     */
    public function show(Invoice $invoice)
    {
        $invoiceWithRelations = Invoice::with(['order', 'discount', 'createdBy', 'updatedBy', 'status'])
            ->find($invoice->id);

        return response(new InvoiceResource($invoiceWithRelations), HttpResponseStatus::OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param InvoiceRequest $request
     * @param Invoice $invoice
     * @return Response
     * @throws Throwable
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $invoice->fill(array_merge(['updated_by' => \Auth::id()], $request->all()))->saveOrFail();

        return response(null, HttpResponseStatus::NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Invoice  $invoice
     * @return Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return response(null, HttpResponseStatus::NO_CONTENT);
    }
}
