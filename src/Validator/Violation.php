<?php

namespace feierstoff\SymPack\Validator;

use feierstoff\SymPack\Exception\ViolationException;

class Violation {

    /**
     * Key of the value that was violated.
     * @var string
     */
    private $target;

    /**
     * Error message that describes the violation.
     * @var string
     */
    private $message;

    /**
     * Name of the constraint that was violated.
     * @var string
     */
    private $constraint;

    function __construct($target, $message, $constraint = "Custom") {
        $this->target = $target;
        $this->message = $message;
        $this->constraint = $constraint;
    }

    public function asArray() {
        return [
            "constraint" => $this->constraint,
            "message" => $this->message,
            "target" => $this->target
        ];
    }

    public function getConstraint() {
        return $this->constraint;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getTarget() {
        return $this->target;
    }

    /**
     * Throw exception with the violation data.
     * @throws ViolationException
     */
    public function violate() {
        throw new ViolationException([$this->asArray()]);
    }

}