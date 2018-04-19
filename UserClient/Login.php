<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19.04.18
 * Time: 10:00
 */

namespace Productors\UserClient;


use GuzzleHttp\Exception\RequestException;

class Login extends BaseClient
{
    const URI = 'login';

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
    public function process($rawBody)
    {
        try {
            $response = $this->callAuth('POST', self::URI, $rawBody);
            return $response;
        } catch (RequestException $e) {
            $response = $this->StatusCodeHandling($e);
            return $response;
        }
    }

}