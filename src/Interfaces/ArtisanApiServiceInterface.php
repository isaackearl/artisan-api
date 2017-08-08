<?php

namespace IsaacKenEarl\LaravelApi\Interfaces;


use IsaacKenEarl\LaravelApi\Exceptions\InvalidResponseCodeException;
use IsaacKenEarl\LaravelApi\Exceptions\InvalidStatusCodeException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use League\Fractal\TransformerAbstract;

interface ArtisanApiServiceInterface
{


    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = []);

    /**
     * @param $item
     * @param TransformerAbstract $transformer
     * @param string $resourceName
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithItem($item, TransformerAbstract $transformer, $resourceName = null);

    /**
     * @param $collection
     * @param TransformerAbstract $transformer
     * @param string $resourceName
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithCollection($collection, TransformerAbstract $transformer, $resourceName = null);

    /**
     * @param LengthAwarePaginator $paginator
     * @param TransformerAbstract $transformer
     * @param string $resourceName
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithPaginatedCollection($paginator, TransformerAbstract $transformer, $resourceName = null);

    /**
     * what includes do you want to include?
     * @param $include
     */
    public function parseIncludes($include);

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithMessage($message);

    /**
     * @param string $message
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not Found!', $data = null);

    /**
     * @param string $message
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInternalError($message = 'Internal Server Error', $data = null);

    /**
     * @param string $message
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusCodeException
     */
    public function respondUnauthorized($message = 'Unauthorized', $data = null);

    /**
     * @param string $message
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message, $data = null);

    /**
     * @param string $message
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusCodeException
     */
    public function respondForbidden($message = 'Forbidden', $data = null);

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondOk();

    /**
     * @return int
     */
    public function getStatusCode();

    /**
     * @return string
     */
    public function getResponseCode();

    /**
     * @param int $statusCode
     * @return $this
     * @throws InvalidStatusCodeException
     */
    public function setStatusCode($statusCode);

    /**
     * @param string $responseCode
     * @return $this
     * @throws InvalidResponseCodeException
     */
    public function setResponseCode($responseCode);
}