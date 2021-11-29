<?php

namespace feierstoff\SymPack\Exception;

use Throwable;

class BadRequestException extends \Exception {

    public function __construct() {
        parent::__construct("", 400);
    }

}