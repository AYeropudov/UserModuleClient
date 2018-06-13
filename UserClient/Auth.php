<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19.04.18
 * Time: 10:02
 */

namespace Productors\UserClient;


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
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process($rawBody = null)
    {
            $response = $this->callAuth('OPTIONS', self::URI, [], true);
            return $response;
    }
}