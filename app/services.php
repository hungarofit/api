<?php

/**
 * @global \Phalcon\DiInterface $di
 */
global $di;

$config = require __DIR__ . '/config.php';

$di->setShared('config', $config);

$di->setShared('db', function() use($config) {
    $db = new Phalcon\Db\Adapter\Pdo\Mysql($config->database->toArray());
    return $db;
});

return $di;
