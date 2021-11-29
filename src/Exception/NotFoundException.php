<?php

namespace feierstoff\SymPack\Exception;

class NotFoundException extends \Exception {

    function __construct() {
        parent::__construct("", 404);
    }

}