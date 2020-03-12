<?php

use Phalcon\Mvc\Micro;

require_once __DIR__ . '/../../vendor/autoload.php';

try {
    $application = new Micro();

    require __DIR__ . '/../Routes.php';

    $application->handle(
        $_SERVER['REQUEST_URI']
    );

} catch (Exception $e) {
    echo $e->getMessage() . ' ' . $e->getTraceAsString();
}