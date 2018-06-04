<?php
include __DIR__ . '/vendor/autoload.php';

class StorageTmp implements \Productors\UserClient\StorageInterface
{

    /**
     * @param string $key
     * @return string
     */
    public function get($key)
    {
        return 'NTg5YjBhYTctYjFlYS00NTEyLWJmNjctNjUwMTQ2';
    }

    /** @return string */
    public function getUuid()
    {
        return '18';
    }
}

//$loginClient = new Login(new StorageTmp());
//$refreshClient = new \Productors\UserClient\Refresh(new StorageTmp());
//$register = new \Productors\UserClient\Register(new StorageTmp());
//$updateClient = new \Productors\UserClient\Update(new StorageTmp());
$authClient = new \Productors\UserClient\Auth(new StorageTmp());
$result = $authClient->process();
print_r($result);