<?php

namespace App\Middleware;

use Phalcon\Events\Event;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;
use App\JsonRpc\BaseJsonRpc;
use App\JsonRpc\ErrorRpc;

/**
 * RequestMiddleware
 *
 * @property Request  $request
 * @property Response $response
 */
class RequestMiddleware implements MiddlewareInterface
{
    /**
     * @param Event $event
     * @param Micro $application
     *
     * @return bool
     */
    public function beforeExecuteRoute(
        Event $event,
        Micro $application
    ): bool {
        json_decode(
            $application
                ->request
                ->getRawBody()
        );

        if (JSON_ERROR_NONE !== json_last_error()) {
            $resp = new BaseJsonRpc();

            $error = new ErrorRpc();
            $error->code =1;
            $error->message = 'request is not json';

            $resp->error = $error;

            $application
                ->response
                ->setJsonContent($resp)
                ->send()
            ;

            return false;
        }

        return true;
    }

    /**
     * @param Micro $application
     *
     * @return bool
     */
    public function call(Micro $application): bool
    {
        return true;
    }
}
