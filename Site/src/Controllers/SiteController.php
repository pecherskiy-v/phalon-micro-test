<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class SiteController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $response = new Response();
        $response->setContentType('text/html');
        $response->sendHeaders();
        $response->setContent(file_get_contents('../Resourse/view/login.html'));
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
