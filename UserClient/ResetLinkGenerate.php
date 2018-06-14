<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 14.06.18
 * Time: 9:43
 */

namespace Productors\UserClient;


/**
 * Class ResetLinkGenerate
 * @package Productors\UserClient
 */
class ResetLinkGenerate extends BaseClient
{
    /**
     *
     */
    const URI = 'reset_password';

    /**
     * ResetLinkGenerate constructor.
     */
    public function __construct(StorageInterface $storage)
    {
        parent::__construct($storage);
    }

    /**
     * @param array $rawBody
     * @return array|mixed|\Psr\Http\Message\ResponseInterface
     */
    public function process(array $rawBody)
    {
        $response = $this->callAuth('POST', self::URI, $rawBody);
        return $response;
    }

}