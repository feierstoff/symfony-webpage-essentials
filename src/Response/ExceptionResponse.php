<?php

namespace feierstoff\SymPack\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ExceptionResponse extends JsonResponse {

    function __construct($e, $env) {
        parent::__construct([
            "message" => $e->getMessage(),
            "trace" => $env == "dev" ? $e->getTrace() : []
        ], 500);
    }

}