<?php

namespace App\JsonRpc;

class BaseJsonRpc
{
    /**
     * версия
     *
     * @var string
     */
    public $jsonrpc = '2.0';
    /**
     * идентификатор запроса
     *
     * @var string
     */
    public $id;
    /**
     * запрашиваемый метод
     *
     * @var string
     * @example 'class/method'
     */
    public $method;
    /**
     * именованный массив параметров
     *
     * @var array
     */
    public $params;

    public function __construct()
    {
        $this->id = uniqid('json-rpc', true);
        $this->params = [];
    }
}
