<?php

namespace feierstoff\SymPack\Validator;

use feierstoff\SymPack\Exception\ViolationException;
use feierstoff\SymPack\Validator\Constraint\NotBlank;

class Validator {

    private $collection;
    private $reference;
    private $violations = [];

    /**
     * Initialize a set of constraints to validate.
     * Validator constructor.
     * @param array $collectionOfConstraints - array of constraints to validate
     * @param $reference - array of values that are checked against the constraints
     */
    function __construct(array $collectionOfConstraints = [], $reference = null) {
        // check if several constraints or just a single one are given
        // if just one: make to an array
        foreach ($collectionOfConstraints as $param => &$item) {
            $this->singleConstraintToArray($item);
        }

        $this->collection = $collectionOfConstraints;
        $this->reference = $reference;
    }

    /**
     * Checks if several constraints are given or just one. If just one,
     * it will be converted to an array.
     * @param $constraints - Constraint(s) to be checked.
     */
    private function singleConstraintToArray(&$constraints) {
        if ($constraints instanceof ConstraintInterface) {
            $constraints = [$constraints];
        }
    }

    /**
     * Add a constraint that needs to be validated.
     * @param $key - key of the value the constraint gets added to
     * @param $constraints - object instance of the constraint
     * @return Validator
     */
    public function add($key, $constraints) {
        // check if just one constraint is given
        $this->singleConstraintToArray($constraints);

        if (in_array($key, $this->collection)) {
            // if constraints for the key already exist: concatenate both lists of constraints
            $this->collection[$key] = array_merge($this->collection[$key], $constraints);
        } else {
            $this->collection[$key] = $constraints;
        }

        return $this;
    }

    /**
     * Set the reference values after instantiating the Validator.
     * @param $reference
     * @return Validator
     */
    public function setReference($reference) {
        $this->reference = $reference;
        return $this;
    }

    /**
     * Checks for every key of constraints the reference array and it's values.
     * If a constraint isn't valid, a violation is added to the violation property.
     * Constraints that are still left to be checked will be ignored.
     */
    public function validate() {
        // Reset all violations from possible previous validations
        $this->violations = [];

        foreach ($this->collection as $key => $constraints) {
            if (array_key_exists($key, $this->reference)) {
                // if value for given constraint key is found in the reference: validate all constraints
                /** @var ConstraintInterface $constraint */
                foreach ($constraints as $constraint) {
                    $error = $constraint->validate($this->reference[$key]);
                    if ($error) {
                        // if constraint was violated, add error and go to next key
                        $error["target"] = $key;
                        $this->violations[] = new Violation($error["target"], $error["message"], $error["constraint"]);
                        break;
                    }
                }
            } else {
                // if value was not found but there is a NotBlank constraint, an error needs to be added
                foreach ($constraints as $constraint) {
                    if ($constraint instanceof NotBlank) {
                        $error = $constraint->validate("");
                        $error["target"] = $key;
                        $this->violations[] = new Violation($error["target"], $error["message"], $error["constraint"]);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Check if there are any violations from the last validation.
     * @return bool
     */
    public function isValid() {
        return sizeof($this->violations) == 0;
    }

    /**
     * @return array
     */
    public function getViolations() {
        return $this->violations;
    }

    /**
     * Converts every violation to an array with it's three key options before returning it.
     * @return array
     */
    public function getViolationsAsArray() {
        $array = [];
        foreach ($this->violations as $violation) {
            $array[] = $violation->asArray();
        }

        return $array;
    }

    /**
     * Throws an error with the current violations.
     * @param bool $withValidation - validates the constraints beforehand if wanted
     * @return Validator
     * @throws ViolationException
     */
    public function violate($withValidation = true) {
        if ($withValidation) {
            $this->validate();
        }

        if (!$this->isValid()) {
            throw new ViolationException($this->getViolationsAsArray());
        }

        return $this;
    }

}