<?php

namespace feierstoff\SymPack\Response;;

use Symfony\Component\HttpFoundation\JsonResponse;

class UnauthorizedResponse extends JsonResponse {

    function __construct($data = null) {
        parent::__construct($data, 401);
    }

}