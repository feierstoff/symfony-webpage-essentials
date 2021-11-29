<?php

namespace feierstoff\SymPack\Util;

class ArrayUtils {
    public static function get($array, $key, $default = null) {
        return array_key_exists($key, $array) ? $array[$key] : $default;
    }
}