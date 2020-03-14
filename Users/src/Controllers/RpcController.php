<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Logger;
use Phalcon\Config;
use App\JsonRpc\BaseJsonRpc;
use AdvancedJsonRpc\Dispatcher;
use App\JsonRpc\ManagerRpc;

/**
 * @property Logger log
 * @property Config config
 */
class RpcController extends Controller
{
    public function main(): BaseJsonRpc
    {
        $resp = new BaseJsonRpc();

        $dispatcher = new Dispatcher(new ManagerRpc(), '/');

        $resp->result = $dispatcher->dispatch($this->request->getRawBody());

        return $resp;
    }
}
