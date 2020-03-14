<?php

namespace App\Middleware;

use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

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
        $payload = [
            'code'    => 200,
            'status'  => 'success',
            'message' => '',
            'payload' => $application->getReturnedValue(),
        ];

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
