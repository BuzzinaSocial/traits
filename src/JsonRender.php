<?php

namespace BuzzinaSocial\Traits;

use stdClass;
use InvalidArgumentException;
use BuzzinaSocial\Traits\Exceptions\JsonException;

use function json_decode;
use function json_last_error;
use function json_last_error_msg;

/**
 * Trait JsonRender.
 *
 * @package BuzzinaSocial\Traits
 */
trait JsonRender
{
    /**
     * Wrapper for json_decode that throws when an error occurs.
     *
     * @param string $json    JSON data to parse
     * @param bool   $assoc     When true, returned objects will be converted into associative arrays.
     * @param int    $depth   User specified recursion depth.
     * @param int    $options Bitmask of JSON decode options.
     *
     * @return mixed
     * @throws InvalidArgumentException if the JSON cannot be decoded.
     *
     * @link http://www.php.net/manual/en/function.json-decode.php
     */
    function jsonDecode(string $json, bool $assoc = false, int $depth = 512, int $options = 0): mixed
    {
        $data = json_decode($json, $assoc, $depth, $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonException('json_decode error: ' . json_last_error_msg());
        }

        return $data;
    }


    /**
     * Wrapper for JSON encoding that throws when an error occurs.
     *
     * @param mixed $value   The value being encoded
     * @param int    $options JSON encode option bitmask
     * @param int    $depth   Set the maximum depth. Must be greater than zero.
     *
     * @return string
     * @throws InvalidArgumentException if the JSON cannot be encoded.
     * @link http://www.php.net/manual/en/function.json-encode.php
     */
    function jsonEncode($value, int $options = 0, int $depth = 512): string
    {
        $json = json_encode($value, $options, $depth);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonException('json_encode error: ' . json_last_error_msg());
        }

        return $json;
    }

    /**
     * Convert to object.
     *
     * @param mixed $string
     *
     * @return stdClass
     */
    public function toObject($string): stdClass
    {
        if (is_string($string)) {
            return $this->jsonDecode($string);
        }

        return $this->jsonDecode($this->jsonEncode($string));
    }

    /**
     * Convert to array.
     *
     * @param mixed $paramns
     *
     * @return array
     */
    public function toArray($paramns): array
    {
        if (is_string($paramns)) {
            return $this->jsonDecode($paramns, true);
        }

        return $this->jsonDecode($this->jsonEncode($paramns), true);
    }
}
