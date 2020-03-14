<?php

use App\Controllers\SiteController;

$application->get('/', [new SiteController(), 'index']);
$application->post('/', [new SiteController(), 'login']);

$application->get('/404', [new SiteController(), 'notFound']);

$application->get('/json', [new SiteController(), 'json']);
