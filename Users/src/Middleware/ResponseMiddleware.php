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
        // фиксация ответов в лог
        $application
            ->response
            ->setContentType('text/html')
            ->sendHeaders()
            ->send();
        $application->log->debug('response', [$application->request->getServerAddress()]);

        return true;
    }
}
