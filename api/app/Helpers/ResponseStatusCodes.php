<?php

namespace App\Helpers;

class ResponseStatusCodes
{
    // success codes
    const OK = '00';
    // error codes
    const VALIDATOR_ERROR = '90';
    const INVALID_AUTH_CREDENTIAL = '91';
    const UNAUTHORIZED = '92';
    const BAD_REQUEST = '93';
    const PERMISSION_DENIED = '99';
}
