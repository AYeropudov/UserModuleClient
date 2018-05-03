<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19.04.18
 * Time: 10:00
 */

namespace Productors\UserClient;


use Productors\UserClient\Exceptions\ClientError;
use Productors\UserClient\Exceptions\CredentialsAreWrong;
use Productors\UserClient\Exceptions\ValidationsErrors;

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
        $response = $this->callAuth('POST', self::URI, $rawBody);
        if (!$response instanceof \stdClass) {
            if (array_key_exists('error', $response)) {
                if ($response['statuscode'] === 412) {
                    throw ValidationsErrors::withDataAndCode($response['error'], 412);
                } elseif ($response['statuscode'] === 401) {
                    throw CredentialsAreWrong::withDataAndCode($response['error'], $response['statuscode']);
                }
                throw ClientError::withDataAndCode($response['error'], $response['statuscode']);
            }
        }
        return $response;
    }

}