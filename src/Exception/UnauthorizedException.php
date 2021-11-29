<?php

namespace feierstoff\SymPack\Exception;

class UnauthorizedException extends \Exception {

    public function __construct() {
        parent::__construct("", 401);
    }

}