<?php

namespace App\Managers;

use App\Models\Users;
use Phalcon\Di;

class LoginValidRpc
{
    public function check(string $login, string $password)
    {
        // return json_encode([$login, $password]);
        // $user = new Users();

        /**
         * @var Users
         */
        $user = Users::findFirst(
            [
                'conditions' => 'login = :login:',
                'bind'       => [
                    'login' => $login,
                ],
            ]
        );

        $security = Di::getDefault()->getSecurity();

        if (false !== $user) {
            $check = $security->checkHash($password, $user->password);
            if (true === $check) {
                // OK
                return 'успешная авторизация';
            }
        }

        // проверка авторизации на основе данных в базе
        return 'неверный логин или пароль';
    }
}
