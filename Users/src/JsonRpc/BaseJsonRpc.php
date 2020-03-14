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
     * сериализованный ответ
     *
     * @var string
     */
    public $result;
    /**
     * @var ErrorRpc
     */
    public $error;
}
