<?php

global $di;

$di = new Phalcon\Di\FactoryDefault\Cli;

require __DIR__ . '/loader.php';
require __DIR__ . '/services.php';

$di->setShared('dispatcher', function() {
    $dispatcher = new Phalcon\Cli\Dispatcher;
    $dispatcher->setDefaultTask('main');
    $dispatcher->setDefaultAction('index');
    $dispatcher->setDefaultNamespace('\Hungarofit\Api\Console\Task');
    return $dispatcher;
});
