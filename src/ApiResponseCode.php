<?php

namespace IsaacKenEarl\LaravelApi;

class ApiResponseCode
{
    const INVALID_REQUEST = 'INVALID_REQUEST';
    const OK = 'OK';
    const NOT_FOUND = 'NOT_FOUND';
    const INTERNAL_ERROR = 'INTERNAL_ERROR';
    const UNAUTHORIZED = 'UNAUTHORIZED';
    const FORBIDDEN = 'FORBIDDEN';
    const INVALID_PARAMETER = 'INVALID_PARAMETER';
    const INACTIVE_ACCOUNT = 'INACTIVE_ACCOUNT';
    const EXPIRED_TOKEN = 'EXPIRED_TOKEN';
}