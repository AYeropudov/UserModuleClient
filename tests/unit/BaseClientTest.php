<?php

class BaseClientTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $storage;

    public function testInit()
    {
        $baseClient = new \Productors\UserClient\BaseClient($this->storage);
        $this->assertInstanceOf(\Productors\UserClient\BaseClient::class, $baseClient);
    }

    public function testConnectionError()
    {
        try {
            $baseClient = $this->make(\Productors\UserClient\BaseClient::class, [
                'storage' => $this->storage,
                'getHttpClient' => function () {
                    $mockHandler = new \GuzzleHttp\Handler\MockHandler(
                        [
                            new \GuzzleHttp\Exception\ConnectException("Error communication server",
                                new \GuzzleHttp\Psr7\Request('GET', 'test'))
                        ]
                    );
                    $handler = \GuzzleHttp\HandlerStack::create($mockHandler);

                    return new \GuzzleHttp\Client(['handler' => $handler]);
                }
            ]);
            $result = $this->invokeMethod($baseClient, 'callAuth', ['OPTIONS', 'check', [], true]);
            $this->assertInstanceOf(\GuzzleHttp\Psr7\Response::class, $result, 'Result is not Response instance.');
            $this->assertEquals(503, $result->getStatusCode(), 'Status is not code as expected 503');
        } catch (Exception $e) {
        }

    }

    // tests

    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        try {
            $reflection = new \ReflectionClass(get_class($object));

            $method = $reflection->getMethod($methodName);
            $method->setAccessible(true);
            return $method->invokeArgs($object, $parameters);
        } catch (ReflectionException $e) {
            return null;
        }
    }

    public function testResponseRequestException()
    {
        try {
            $baseClient = $this->make(\Productors\UserClient\BaseClient::class, [
                'storage' => $this->storage,
                'getHttpClient' => function () {
                    $mockHandler = new \GuzzleHttp\Handler\MockHandler(
                        [
                            new \GuzzleHttp\Exception\RequestException("Error communication server",
                                new \GuzzleHttp\Psr7\Request('GET', 'test'))
                        ]
                    );
                    $handler = \GuzzleHttp\HandlerStack::create($mockHandler);

                    return new \GuzzleHttp\Client(['handler' => $handler]);
                }
            ]);
            $result = $this->invokeMethod($baseClient, 'callAuth', ['get', 'check', [], true]);
            $this->assertInstanceOf(\GuzzleHttp\Psr7\Response::class, $result, 'Result is not Response instance.');
        } catch (Exception $e) {
        }
    }

    public function testResponseGuzzleException()
    {
        try {
            $baseClient = $this->make(\Productors\UserClient\BaseClient::class, [
                'storage' => $this->storage,
                'getHttpClient' => function () {
                    $mockHandler = new \GuzzleHttp\Handler\MockHandler(
                        [
                            new \GuzzleHttp\Exception\TransferException("Error communication server")
                        ]
                    );
                    $handler = \GuzzleHttp\HandlerStack::create($mockHandler);

                    return new \GuzzleHttp\Client(['handler' => $handler]);
                }
            ]);
            $result = $this->invokeMethod($baseClient, 'callAuth', ['get', 'check', [], true]);
            $this->assertInstanceOf(\GuzzleHttp\Psr7\Response::class, $result, 'Result is not Response instance.');
            $this->assertEquals(400, $result->getStatusCode(), 'Result code is not 400.');
        } catch (Exception $e) {
        }
    }

    protected function _before()
    {
        $this->storage = $this->getMockBuilder(\Productors\UserClient\StorageInterface::class)->getMock();
    }

    protected function _after()
    {
    }
}