<?php

namespace feierstoff\SymPack\Validator;

interface ConstraintInterface {
    public function validate($value);
}