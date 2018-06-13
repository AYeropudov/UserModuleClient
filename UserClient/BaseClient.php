<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19.04.18
 * Time: 10:06
 */

namespace Productors\UserClient;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Productors\UserClient\Exceptions\PasswordChangeException;

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
            $response = $this->getHttpClient()->request($method, $url, array('json' => $body, 'headers' => $header));

            if ($response->getStatusCode() === 303) {
                throw new PasswordChangeException('Нужно сменить пароль');
            }
            return $response;
        } catch (ConnectException $connectException) {
            return new Response(503, ['Content-Type' => 'application/json',],
                json_encode(['message' => 'service is not available']));
        } catch (RequestException $e) {
            return $e->getResponse();
        } catch (GuzzleException $e) {
            return new Response(
                400,
                [
                    'Content-Type' => 'application/json',
                ],
                json_encode([
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                ])
            );
        }
    }

    private function prepareAccessToken()
    {
        $this->accessToken = $this->storage->get('accessToken');
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }
}