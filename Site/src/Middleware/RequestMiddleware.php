<?php

namespace App\Middleware;

use Phalcon\Events\Event;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

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
    ) {
        $body = $application
            ->request
            ->getPost();
        $query = $application
            ->request
            ->getQuery();
        $uri = $application
            ->request
            ->getURI(true);

        var_dump(
            [
                'body'  => $body,
                'query' => $query,
                'uri'   => $uri,
            ]
        );

        return true;
    }

    /**
     * @param Micro $application
     *
     * @return bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}