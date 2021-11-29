<?php

namespace feierstoff\SymPack\Exception;

class ViolationException extends \Exception {

    private $violations;

    function __construct($violations = null) {
        $this->violations = $violations;

        parent::__construct("", 422);
    }

    function getViolations() {
        return $this->violations;
    }

}