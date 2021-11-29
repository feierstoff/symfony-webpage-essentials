<?php

namespace feierstoff\SymPack\Exception;

use Throwable;

class ForbiddenException extends \Exception {

    public function __construct() {
        parent::__construct("", 403);
    }

}