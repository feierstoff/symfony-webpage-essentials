<?php

namespace feierstoff\SymPack\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ConflictResponse extends JsonResponse {

    function __construct($conflictEntity) {
        parent::__construct($conflictEntity, 409);
    }

}