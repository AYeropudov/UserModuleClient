<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19.04.18
 * Time: 10:01
 */

namespace Productors\UserClient;


class Register extends BaseClient
{
    const URI = 'create';

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
            $response = $this->callAuth('POST', self::URI, $rawBody, false);
            return $response;
    }
}