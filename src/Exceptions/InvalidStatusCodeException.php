<?php

namespace IsaacKenEarl\LaravelApi\Exceptions;


use Exception;

class InvalidStatusCodeException extends Exception
{

    /**
     * @var integer
     */
    protected $statusCode = 500;

    /**
     * @param string $message
     * @param integer $statusCode
     */
    public function __construct($message = 'Invalid Status Code (must be int)', $statusCode = null)
    {
        parent::__construct($message);

        if (!is_null($statusCode)) {
            $this->setStatusCode($statusCode);
        }
    }

    /**
     * @return integer the status code
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param integer $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

}