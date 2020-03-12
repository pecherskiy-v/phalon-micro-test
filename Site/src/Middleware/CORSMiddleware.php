<?php

use Phalcon\Events\Event;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * CORSMiddleware
 *
 * @property Request  $request
 * @property Response $response
 */
class CORSMiddleware implements MiddlewareInterface
{
    /**
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeHandleRoute(
        Event $event,
        Micro $application
    ) {
        if ($application->request->getHeader('ORIGIN')) {
            $origin = $application
                ->request
                ->getHeader('ORIGIN')
            ;
        } else {
            $origin = '*';
        }

        $application
            ->response
            ->setHeader(
                'Access-Control-Allow-Origin',
                $origin
            )
            ->setHeader(
                'Access-Control-Allow-Methods',
                'GET,PUT,POST,DELETE,OPTIONS'
            )
            ->setHeader(
                'Access-Control-Allow-Headers',
                'Origin, X-Requested-With, Content-Range, ' .
                'Content-Disposition, Content-Type, Authorization'
            )
            ->setHeader(
                'Access-Control-Allow-Credentials',
                'true'
            )
        ;
    }

    /**
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}
