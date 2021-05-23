<?php

namespace App\Http\Controllers;

use App\Http\Enums\HttpResponseStatus;
use App\Http\Resources\CountryCollection;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CountryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return response(new CountryCollection(Country::all()), HttpResponseStatus::OK);
    }
}
