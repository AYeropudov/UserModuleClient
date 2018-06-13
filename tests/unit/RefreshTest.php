<?php

class RefreshTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;
    private $storage;

    public function testInit()
    {
        $client = new \Productors\UserClient\Refresh($this->storage);

        $this->assertInstanceOf(\Productors\UserClient\BaseClient::class, $client);
        $this->assertInstanceOf(\Productors\UserClient\Refresh::class, $client);
    }

    public function testProcess()
    {
        $client = new \Productors\UserClient\Refresh($this->storage);
        $result = $client->process([]);

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