<?php

namespace feierstoff\SymPack\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class CreatedResponse extends JsonResponse {

    function __construct($createdObject) {
        parent::__construct($createdObject, 201);
    }

}