<?php

namespace IsaacKenEarl\LaravelApi\Exceptions;


use Exception;

class InvalidResponseCodeException extends Exception
{

    /**
     * @var integer
     */
    protected $responseCode = 500;

    /**
     * @param string $message
     * @param integer $statusCode
     */
    public function __construct($message = 'Invalid Response Code (must be string)', $statusCode = null)
    {
        parent::__construct($message);

        if (!is_null($statusCode)) {
            $this->setResponseCode($statusCode);
        }
    }

    /**
     * @return integer the status code
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @param integer $responseCode
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
    }

}