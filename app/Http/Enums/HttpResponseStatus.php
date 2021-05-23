<?php

namespace App\Http\Enums;

use BenSampo\Enum\Enum;

final class HttpResponseStatus extends Enum
{
    const OK = 200;
    const CREATED = 201;
    const NO_CONTENT = 204;
    const FOUND = 302;
    const BAD_REQUEST = 400;
    const NOT_FOUND = 404;
}
