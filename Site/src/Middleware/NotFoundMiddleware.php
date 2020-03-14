<?php

namespace App\Middleware;

use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * NotFoundMiddleware
 *
 * @property Response $response
 */
class NotFoundMiddleware implements MiddlewareInterface
{
    /**
     * @return bool
     */
    public function beforeNotFound()
    {
        (new Response())->redirect('/404')->send();

        return false;
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
