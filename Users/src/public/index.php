<?php

use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Config;
use Phalcon\Config\ConfigFactory;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Events\Manager;
use Phalcon\Session;
use Phalcon\Session\Adapter\Stream as SessionStream;
use Phalcon\Db\Adapter\Pdo\Sqlite;
use App\Formatter\Formatter;
use App\Middleware\RequestMiddleware;
use App\Middleware\ResponseMiddleware;
use Phalcon\Mvc\Model\MetaData\Memory;
use Phalcon\Mvc\Model\Manager as ModelManager;

// use App\Middleware\FirewallMiddleware;

require_once __DIR__ . '/../../vendor/autoload.php';

$Loader = new josegonzalez\Dotenv\Loader(__DIR__ . '/../.env');
$Loader->parse()->putenv();

$config = new Config();
$factory = new ConfigFactory();
$appConfig = $factory->newInstance('php', __DIR__ . '/../Config/App.php');
$config->merge($appConfig);
$loggingConfig = $factory->newInstance('php', __DIR__ . '/../Config/Logging.php');
$config->merge($loggingConfig);
$dbConfig = $factory->newInstance('php', __DIR__ . '/../Config/DataBase.php');
$config->merge($dbConfig);

$manager = new Manager();
// $manager->attach('micro', new FirewallMiddleware());
$manager->attach('micro', new RequestMiddleware());
$manager->attach('micro', new ResponseMiddleware());

$container = new FactoryDefault();
$container->set('config', $config);
$container->set(
    'log',
    function () use ($config) {
        $adapter = new Stream(__DIR__ . '/../Storage/logs/main.log');

        $formatter = new Formatter();
        $formatter->setDateFormat('Y-m-d H:i:s');
        $adapter->setFormatter($formatter);
        $logger = new Logger(
            'messages',
            [
                'main' => $adapter,
            ]
        );

        $level = strtoupper($config->path('logging.Level'));
        switch ($level) {
            case 'ALERT':
                $logger->setLogLevel(Logger::ALERT);
                break;
            case 'CRITICAL':
                $logger->setLogLevel(Logger::CRITICAL);
                break;
            case 'CUSTOM':
                $logger->setLogLevel(Logger::CUSTOM);
                break;
            case 'DEBUG':
                $logger->setLogLevel(Logger::DEBUG);
                break;
            case 'EMERGENCY':
                $logger->setLogLevel(Logger::EMERGENCY);
                break;
            case 'ERROR':
                $logger->setLogLevel(Logger::ERROR);
                break;
            case 'INFO':
                $logger->setLogLevel(Logger::INFO);
                break;
            case 'NOTICE':
                $logger->setLogLevel(Logger::NOTICE);
                break;
            case 'WARNING':
                $logger->setLogLevel(Logger::WARNING);
                break;
            default:
                $logger->setLogLevel(Logger::ALERT);
        }

        return $logger;
    }
);
$container->setShared(
    'session',
    function () {
        $adapter = new SessionStream(['savePath' => __DIR__ . '/../Storage/session/']);

        $session = new Session\Manager();
        $session->setAdapter($adapter);
        $session->start();

        return $session;
    }
);
$container->set('db', new Sqlite($config->get('db')->toArray()));
$container->set('modelsManager', new ModelManager());
$container->set('modelsMetadata', new Memory());

$container->set('loginValidRpc', new App\Managers\LoginValidRpc);

try {
    $application = new Micro($container);

    // $application->before(new FirewallMiddleware());
    $application->before(new RequestMiddleware());
    $application->after(new ResponseMiddleware());

    $application->setEventsManager($manager);

    require __DIR__ . '/../Config/Routes.php';

    $application->handle(
        $_SERVER['REQUEST_URI']
    );
} catch (Exception $e) {
    echo $e->getMessage() . ' ' . $e->getTraceAsString();
}