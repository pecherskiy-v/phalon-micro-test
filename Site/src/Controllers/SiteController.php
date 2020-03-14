<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Phalcon\Logger;
use Phalcon\Config;
use App\Validators\LoginValidation;
use GuzzleHttp\Client;
use App\JsonRpc\BaseJsonRpc;

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
        $content = $this->view->render('login', []);

        $response = new Response();
        $response->setContent($content);
        $this->log->debug('open index page');
        return $response;
    }

    public function login(): Response
    {
        $validation = new LoginValidation();

        if (!$this->security->checkToken()) {
            $response = new Response();
            $response->redirect('/');
            return $response;
        }

        $messages = $validation->validate($this->request->getPost());

        $content = 'ok';
        if (count($messages)) {
            $content = 'fail<br>';
            foreach ($messages as $message) {
                $content .= $message . '<br>';
            }
        }

        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $response = new Response();
        $response->setContent($content);
        return $response;
    }

    public function notFound(): Response
    {
        $response = new Response();
        $response->setContent('404');
        return $response;
    }

    public function json():Response
    {
        $query = new BaseJsonRpc();
        $query->method = 'loginValid/check';
        $query->params = [
            'login' => 'admin',
            'password' => 'test'
        ];

        $url = $this->config->get('rpc')->get('user');

        $client = new Client();
        $result = $client->request('POST', $url, ['json' => $query]);

        $result = json_decode($result->getBody()->getContents());

        $response = new Response();
        $response->setContent($result->result);
        return $response;
    }
}
