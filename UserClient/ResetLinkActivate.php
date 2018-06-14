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
class ResetLinkActivate extends BaseClient
{
    /**
     *
     */
    const URI = 'reset_link';

    /**
     * ResetLinkGenerate constructor.
     */
    public function __construct(StorageInterface $storage)
    {
        parent::__construct($storage);
    }

    /**
     * @param string $uuid
     * @return array|mixed|\Psr\Http\Message\ResponseInterface
     */
    public function process($uuid)
    {
        $response = $this->callAuth('POST', self::URI . '/' . $uuid, []);
        return $response;
    }

}