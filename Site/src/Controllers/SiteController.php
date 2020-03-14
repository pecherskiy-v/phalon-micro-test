<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Phalcon\Logger;
use Phalcon\Config;

/**
 * @property Logger log
 * @property Config config
 */
class SiteController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $response = new Response();
        $response->setContent(file_get_contents('../Resource/view/login.html'));
        $this->log->debug('open index page');
        return $response;
    }

    public function login(): Response
    {
        $response = new Response();
        $response->setContentType('text/html');
        $response->sendHeaders();
        $response->setContent('ok');
        return $response;
    }
}
