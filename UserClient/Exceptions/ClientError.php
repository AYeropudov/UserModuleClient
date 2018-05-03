<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 03.05.18
 * Time: 13:41
 */

namespace Productors\UserClient\Exceptions;


/**
 * Class ValidationsErrors
 * @package Productors\UserClient\Exceptions
 */
class ClientError extends \RuntimeException
{
    /**
     * @var mixed
     */
    private $data;
    /**
     * @var integer
     */
    private $statusCode;

    /**
     * @param mixed $data
     * @param integer $code
     * @return ClientError
     */
    public static function withDataAndCode($data, $code)
    {
        $result = new self();
        $result->setData($data);
        $result->setStatusCode($code);
        return $result;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param integer $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }
}