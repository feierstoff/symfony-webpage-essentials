<?php

namespace feierstoff\SymPack\Validator\Constraint;

use feierstoff\SymPack\Validator\ConstraintInterface;

class NotBlank implements ConstraintInterface {

    private $msg;

    function __construct($msg = "This value should not be blank.") {
        $this->msg = $msg;
    }

    public function validate($value) {
        return empty($value) ? [
            "constraint" => "NotBlank",
            "message" => $this->msg
        ] : null;
    }
}