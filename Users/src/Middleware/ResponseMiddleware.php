<?php

namespace App\Middleware;

use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;
use App\JsonRpc\BaseJsonRpc;
use App\JsonRpc\ErrorRpc;

/**
 * ResponseMiddleware
 *
 * @property Response $response
 */
class ResponseMiddleware implements MiddlewareInterface
{
    /**
     * @param Micro $application
     *
     * @return bool
     */
    public function call(Micro $application): bool
    {
        /**
         * @var BaseJsonRpc $payload
         */
        $payload = $application->getReturnedValue();
        $req = $application->request->getJsonRawBody(true);

        if (!($payload instanceof BaseJsonRpc)) {
            $payload = new BaseJsonRpc();

            $error = new ErrorRpc();
            $error->code = 1;
            $error->message = 'response error';

            $payload->error = $error;
        }
        $payload->id = $req['id']??'no req id';

        $application
            ->response
            ->setJsonContent($payload)
            ->send()
        ;

        // фиксация ответов в лог
        $application->log->debug('response', [$application->request->getServerAddress()]);

        return true;
    }
}
