<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19.04.18
 * Time: 10:33
 */

namespace Productors\UserClient;


interface StorageInterface
{
    /**
     * @param string $key
     * @return string
     */
    public function get($key);

    /** @return string */
    public function getUuid();
}