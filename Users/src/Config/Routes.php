<?php

use App\Controllers\RpcController;

$application->post('/rpc', [new RpcController(), 'main']);
