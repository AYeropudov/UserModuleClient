<?php
include __DIR__ . '/vendor/autoload.php';

use Productors\UserClient\Login;

class StorageTmp implements \Productors\UserClient\StorageInterface
{

    /**
     * @param string $key
     * @return string
     */
    public function get($key)
    {
        return 'YmQyMGZmMDctNjkxZi00ZWE5LTg3MDctNjg0YjXx';
    }

    /** @return string */
    public function getUuid()
    {
        return '4ee5e480-43ac-11e8-b7ca-2c4d54e964cc';
    }
}

$loginClient = new Login(new StorageTmp());
$refreshClient = new \Productors\UserClient\Refresh(new StorageTmp());
$register = new \Productors\UserClient\Register(new StorageTmp());
$updateClient = new \Productors\UserClient\Update(new StorageTmp());
$authClient = new \Productors\UserClient\Auth(new StorageTmp());
$result = $authClient->process();
print_r($result);