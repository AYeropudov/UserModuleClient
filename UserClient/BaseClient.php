<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19.04.18
 * Time: 10:06
 */

namespace Productors\UserClient;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class BaseClient
{
    const HOST = 'http://auth.soc.api/';
    /** @var string */
    protected $accessToken;
    /** @var string */
    protected $refreshToken;
    /** @var StorageInterface */
    protected $storage;
    /** @var Client */
    private $httpClient;

    /**
     * BaseClient constructor.
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->httpClient = new Client([
            'base_uri' => self::HOST,
            // You can set any number of default request options.
        ]);

        $this->storage = $storage;
    }

    /**
     * @param $method
     * @param $request
     * @param $body
     * @param bool $needToken
     * @return array|mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function callAuth($method, $request, $body, $needToken = false)
    {
        try {
            $header = [];
            if ($needToken) {
                $this->prepareAccessToken();
                $header = array('Authorization' => 'Bearer ' . $this->accessToken);
            }
            $url = self::HOST . $request;
            $response = $this->httpClient->request($method, $url, array('json' => $body, 'headers' => $header));
            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            $response = $this->StatusCodeHandling($e);
            return $response;
        } catch (GuzzleException $e) {
            return [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
        }
    }

    private function prepareAccessToken()
    {
        $this->accessToken = $this->storage->get('accessToken');
    }

    protected function statusCodeHandling(RequestException $e)
    {
        $response = array(
            "statuscode" => $e->getResponse()->getStatusCode(),
            "error" => json_decode($e->getResponse()->getBody(true)->getContents())
        );
        return $response;
    }

    /**
     * @return Client
     */
    protected function getHttpClient()
    {
        return $this->httpClient;
    }
}