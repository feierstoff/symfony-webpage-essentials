<?php

namespace feierstoff\SymPack\Response;;

use Symfony\Component\HttpFoundation\JsonResponse;

class ViolationResponse extends JsonResponse {

    function __construct($violations = null) {
        $data = $violations ? [
            "violations" => $violations
        ] : null;

        parent::__construct($data, 422);
    }

}