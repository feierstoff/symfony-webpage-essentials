<?php

namespace feierstoff\SymPack\Response;;

use Symfony\Component\HttpFoundation\JsonResponse;

class OkResponse extends JsonResponse {

    function __construct($data = null) {
        parent::__construct($data, 200);
    }

}