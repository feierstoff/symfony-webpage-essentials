<?php

namespace feierstoff\SymPack\Response;;

use Symfony\Component\HttpFoundation\JsonResponse;

class NotModifiedResponse extends JsonResponse {

    function __construct($msg = "") {
        parent::__construct($msg, 304);
    }

}