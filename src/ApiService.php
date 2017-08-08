<?php
/**
 * Created by PhpStorm.
 * User: isaacearl
 * Date: 7/4/17
 * Time: 5:30 PM
 */

namespace IsaacKenEarl\LaravelApi;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use IsaacKenEarl\LaravelApi\Exceptions\InvalidResponseCodeException;
use IsaacKenEarl\LaravelApi\Exceptions\InvalidStatusCodeException;
use IsaacKenEarl\LaravelApi\Interfaces\ApiServiceInterface;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\TransformerAbstract;
use Spatie\Fractal\Fractal;

class ApiService implements ApiServiceInterface
{


    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @var string
     */
    protected $responseCode = ApiResponseCode::OK;

    /**
     * @var \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * @var \Spatie\Fractal\Fractal
     */
    protected $fractal;

    /**
     * ApiService constructor.
     */
    public function __construct(ResponseFactory $response, Fractal $fractal)
    {
        $this->response = $response;
        $this->fractal = $fractal;
    }

    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        $data = $data + ['response_code' => $this->getResponseCode()];
        return $this->response->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $item
     * @param TransformerAbstract $transformer
     * @param string $resourceName
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithItem($item, TransformerAbstract $transformer, $resourceName = null)
    {
        if (!$item) {
            return $this->respondNotFound();
        }

        return $this->respond(
            $this->fractal
                ->item($item, $transformer)
                ->withResourceName($resourceName)
                ->toArray()
        );
    }

    /**
     * @param $collection
     * @param TransformerAbstract $transformer
     * @param string $resourceName
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithCollection($collection, TransformerAbstract $transformer, $resourceName = null)
    {

        if (!$collection) {
            return $this->respondNotFound();
        }

        return $this->respond(
            $this->fractal
                ->collection($collection, $transformer)
                ->withResourceName($resourceName)
                ->toArray()
        );
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @param TransformerAbstract $transformer
     * @param string $resourceName
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithPaginatedCollection($paginator, TransformerAbstract $transformer, $resourceName = null)
    {

        if (!$paginator) {
            return $this->respondNotFound();
        }

        return $this->respond(
            $this->fractal
                ->collection($paginator->items(), $transformer)
                ->paginateWith(new IlluminatePaginatorAdapter($paginator))
                ->withResourceName($resourceName)
                ->toArray()
        );
    }

    /**
     * what includes do you want to include?
     * @param $include
     */
    public function parseIncludes($include)
    {
        $this->fractal->parseIncludes($include);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithMessage($message)
    {
        return $this->respond(['message' => $message]);
    }

    /**
     * @param string $message
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not Found!', $data = null)
    {
        return $this->setStatusCode(404)
            ->setResponseCode(ApiResponseCode::NOT_FOUND)
            ->respondWithError($message, $data);
    }

    /**
     * @param string $message
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInternalError($message = 'Internal Server Error', $data = null)
    {
        return $this->setStatusCode(500)
            ->setResponseCode(ApiResponseCode::INTERNAL_ERROR)
            ->respondWithError($message, $data);
    }

    /**
     * @param string $message
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusCodeException
     */
    public function respondUnauthorized($message = 'Unauthorized', $data = null)
    {
        return $this->setStatusCode(401)
            ->setResponseCode(ApiResponseCode::UNAUTHORIZED)
            ->respondWithError($message, $data);
    }

    /**
     * @param string $message
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message, $data = null)
    {
        if ($this->statusCode == 200) {
            $this->statusCode = 400;
        }

        if ($this->responseCode == ApiResponseCode::OK) {
            $this->responseCode = ApiResponseCode::INVALID_REQUEST;
        }

        $response = ['error' => $message];

        if ($data) {
            $response = $response + $data; // use the union because we don't want to override the message
        }

        return $this->respond($response);
    }

    /**
     * @param string $message
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusCodeException
     */
    public function respondForbidden($message = 'Forbidden', $data = null)
    {
        return $this
            ->setStatusCode(403)
            ->setResponseCode(ApiResponseCode::FORBIDDEN)
            ->respondWithError($message, $data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondOk()
    {
        return $this->respondWithMessage('OK');
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return (int)$this->statusCode;
    }

    /**
     * @return string
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @param int $statusCode
     * @return $this
     * @throws InvalidStatusCodeException
     */
    public function setStatusCode($statusCode)
    {
        if (!is_int($statusCode)) {
            throw new InvalidStatusCodeException();
        }

        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param string $responseCode
     * @return $this
     * @throws InvalidResponseCodeException
     */
    public function setResponseCode($responseCode)
    {
        if (!is_string($responseCode)) {
            throw new InvalidResponseCodeException();
        }

        $this->responseCode = $responseCode;

        return $this;
    }
}