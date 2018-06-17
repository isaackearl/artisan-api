<?php

namespace IsaacKenEarl\LaravelApi;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use IsaacKenEarl\LaravelApi\Exceptions\InvalidResponseCodeException;
use IsaacKenEarl\LaravelApi\Exceptions\InvalidStatusCodeException;
use IsaacKenEarl\LaravelApi\Interfaces\ArtisanApiServiceInterface;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\TransformerAbstract;
use Spatie\Fractal\Fractal;

class ArtisanApiService implements ArtisanApiServiceInterface
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

    protected $errorKey = 'error';

    protected $errorDataKey = 'errors';

    protected $messageKey = 'message';

    /**
     * ArtisanApiService constructor.
     * @param ResponseFactory $response
     * @param Fractal $fractal
     */
    public function __construct(ResponseFactory $response, Fractal $fractal)
    {
        if (function_exists('config')) {
            $this->errorKey = config('api.error_message_key');
            $this->errorDataKey = config('api.error_data_key');
            $this->messageKey = config('api.message_key');
        }

        $this->response = $response;
        $this->fractal = $fractal;
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
     * @param string $message
     * @param array $data
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
     * @param array $data
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

        $response = [$this->errorKey => $message];

        if ($data) {
            $response = $response + [$this->errorDataKey => $data]; // use the union because we don't want to override the message
        }

        return $this->respond($response);
    }

    /**
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        $data = $data + ['response_code' => $this->getResponseCode()];
        return $this->response->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @return string
     */
    public function getResponseCode()
    {
        return $this->responseCode;
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

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return (int)$this->statusCode;
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
     * @param string $message
     * @param array $data
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
     * @param array $data
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
     * @param array $data
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
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithMessage($message)
    {
        return $this->respond([$this->messageKey => $message]);
    }
}