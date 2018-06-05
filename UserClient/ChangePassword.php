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
use Productors\UserClient\Exceptions\CredentialsAreWrong;
use Productors\UserClient\Exceptions\ValidationsErrors;

class ChangePassword extends BaseClient
{
    const URI = 'change_password';

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
            $response = $this->callAuth('PATCH', self::URI . '/' . $this->storage->getUuid(), $rawBody, true);
            if (!$response instanceof \stdClass) {
                if (array_key_exists('error', $response)) {
                    if ($response['statuscode'] === 412) {
                        throw ValidationsErrors::withDataAndCode($response['error'], 412);
                    } elseif ($response['statuscode'] === 404) {
                        throw CredentialsAreWrong::withDataAndCode($response['error'], $response['statuscode']);
                    }
                    throw ClientError::withDataAndCode($response['error'], $response['statuscode']);
                }
            }
        } catch (RequestException $e) {
            $response = $this->StatusCodeHandling($e);
            throw ClientError::withDataAndCode($response['error'], $response['statuscode']);
        }
    }
}