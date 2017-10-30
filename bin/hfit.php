<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../app/bootstrap_cli.php';

global $di;

try {
    $arguments = [];
    foreach ($argv as $k => $arg) {
        if ($k === 1) {
            $arguments["task"] = $arg;
        } elseif ($k === 2) {
            $arguments["action"] = $arg;
        } elseif ($k >= 3) {
            $arguments["params"][] = $arg;
        }
    }
    $app = new \Hungarofit\Api\Console\Application($di);
    $app->handle($arguments);
}
catch(\Exception $e) {
    throw $e;
}
