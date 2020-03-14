<?php

namespace App\Middleware;

use Phalcon\Events\Event;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * FirewallMiddleware
 *
 * @property Request  $request
 * @property Response $response
 */
class FirewallMiddleware implements MiddlewareInterface
{
    /**
     * @param Event $event
     * @param Micro $application
     *
     * @return bool
     */
    public function beforeHandleRoute(
        Event $event,
        Micro $application
    ) {
        $whitelist = [
            '10.4.6.1',
            '10.4.6.2',
            '10.4.6.3',
            '10.4.6.4',
        ];

        $ipAddress = $application
            ->request
            ->getClientAddress()
        ;

        if (true !== array_key_exists($ipAddress, $whitelist)) {
            $this
                ->response
                ->redirect('/401')
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
    public function call(Micro $application)
    {
        return true;
    }
}
