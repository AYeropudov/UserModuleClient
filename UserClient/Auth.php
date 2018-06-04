<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19.04.18
 * Time: 10:02
 */

namespace Productors\UserClient;


use GuzzleHttp\Exception\RequestException;
use Productors\UserClient\Exceptions\ClientError;

class Auth extends BaseClient
{
    const URI = 'check';

    /**
     * Login constructor.
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        parent::__construct($storage);
    }

    /**
     * @param array $rawBody
     * @return array|mixed|\Psr\Http\Message\ResponseInterface
     */
    public function process($rawBody = null)
    {
        try {
            $response = $this->callAuth('OPTIONS', self::URI, [], true);
            return $response;
        } catch (RequestException $e) {
            $response = $this->StatusCodeHandling($e);
            throw ClientError::withDataAndCode($response['error'], $response['statuscode']);
        }
    }
}