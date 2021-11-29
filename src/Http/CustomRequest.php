<?php

namespace feierstoff\SymPack\Http;

use Symfony\Component\HttpFoundation\Request;

class CustomRequest {

    /**
     * @var Request - Instance of the original symfony request.
     */
    private $request;

    /**
     * @var mixed - Body of the request.
     */
    private $payload;

    /* possible type conversions for request-parameters */
    const TYPE_BOOL = "bool";
    const TYPE_DATETIME = "datetime";

    function __construct(Request $request) {
        $this->request = $request;
        $this->payload = $request->getContent() ? json_decode($request->getContent(), true) : [];

        // empty payload if json decoding failed
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->payload = [];
        }
    }

    /**
     * Search for given key in query string or request body.
     *
     * @param $key
     * @param null $default - default return value if given key is not found
     * @param string - optional type conversion
     * @return mixed
     */
    public function get($key, $default = null, $type = "") {
        $value = $default;

        // search for key in every possible part of the request
        switch (true) {
            case $this->request->query->has($key):
                $value = $this->request->query->get($key);
                break;
            case $this->request->request->has($key):
                $value = $this->request->get($key);
                break;
            case array_key_exists($key, $this->payload):
                $value = $this->payload[$key];
                break;
            default:
                // return default value, if key was not found
                return $default;
        }

        // check if type conversion is wanted
        switch ($type) {
            case self::TYPE_BOOL:
                $value = filter_var($value, FILTER_VALIDATE_BOOL);
                break;
            case self::TYPE_DATETIME:
                try {
                    $value = new \DateTime($value);
                } catch (\Exception $e) {
                    return null;
                }
                break;
        }

        return $value;
    }

    /**
     * Alias function because my brian can't remember shit.
     * @return string
     */
    public function getUrlBase() {
        return $this->request->getSchemeAndHttpHost();
    }

    /**
     * Same thing.
     * @return string
     */
    public function getDomain() {
        return $this->request->getHost();
    }

    /**
     * ...
     * @return string
     */
    public function getRoute() {
        return $this->request->getPathInfo();
    }

    /**
     * Returns the request method.
     * @return string
     */
    public function getMethod() {
        return $this->request->getMethod();
    }

}