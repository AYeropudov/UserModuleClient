<?php

class AuthTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;
    private $storage;

    public function testInit()
    {
        $client = new \Productors\UserClient\Auth($this->storage);

        $this->assertInstanceOf(\Productors\UserClient\BaseClient::class, $client);
        $this->assertInstanceOf(\Productors\UserClient\Auth::class, $client);
    }

    public function testProcess()
    {
        $client = new \Productors\UserClient\Auth($this->storage);
        $result = $client->process();

        $this->assertInstanceOf(\GuzzleHttp\Psr7\Response::class, $result);
    }

    // tests

    protected function _before()
    {
        $this->storage = $this->getMockBuilder(\Productors\UserClient\StorageInterface::class)->getMock();
    }

    protected function _after()
    {
    }
}