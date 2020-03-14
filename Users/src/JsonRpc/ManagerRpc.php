<?php

namespace App\JsonRpc;

use App\Managers\LoginValidRpc;

class ManagerRpc
{
    /**
     * @var LoginValidRpc
     */
    public $loginValid;

    public function __construct()
    {
        $this->loginValid = new LoginValidRpc();
    }
}
