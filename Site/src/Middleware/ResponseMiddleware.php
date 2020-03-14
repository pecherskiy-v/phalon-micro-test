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
        $application->log->debug(
            'response',
            [
                'ServerAddress' => $application->request->getServerAddress(),
                'Query' => $application->request->getQuery(true),
                'Method' => $application->request->getMethod(),
                'HTTPReferer' => $application->request->getHTTPReferer()
            ]
        );

        return true;
    }
}
