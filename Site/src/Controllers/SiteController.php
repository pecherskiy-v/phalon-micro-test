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

        if (count($messages)) {
            $content = 'fail<br>';
            foreach ($messages as $message) {
                $content .= $message . '<br>';
            }

            $response = new Response();
            $response->setContent($content);
            return $response;
        }

        $login = $this->request->getPost('login', 'string');
        $password = $this->request->getPost('password', 'string');

        $query = new BaseJsonRpc();
        $query->method = 'loginValid/check';
        $query->params = [
            'login' => $login,
            'password' => $password
        ];

        $url = $this->config->get('rpc')->get('user');

        $client = new Client();
        $result = $client->request('POST', $url, ['json' => $query]);

        $result = json_decode($result->getBody()->getContents());
        // $result = $result->getBody()->getContents();

        $response = new Response();
        $response->setContent($result->result);
        // $response->setContent($result);
        return $response;
    }

    public function notFound(): Response
    {
        $response = new Response();
        $response->setContent('404');
        return $response;
    }
}
