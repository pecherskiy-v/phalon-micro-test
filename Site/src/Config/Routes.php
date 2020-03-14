<?php

use App\Controllers\SiteController;

$application->get('/', [new SiteController(), 'index']);
$application->post('/', [new SiteController(), 'login']);
