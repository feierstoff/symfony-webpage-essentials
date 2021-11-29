<?php

namespace feierstoff\SymPack\Response;;

use Symfony\Component\HttpFoundation\JsonResponse;

class NotFoundResponse extends JsonResponse {

    function __construct($data = null) {
        parent::__construct($data, 404);
    }

}