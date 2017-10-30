<?php

namespace Hungarofit\Api\Console\Task;


class SelfhostTask extends BaseTask
{
    public function indexAction()
    {
        try {
            $address = $this->config->selfhost->address;
        }
        catch(\Exception $e) {
            $address = 'localhost:8080';
        }
        chdir(__DIR__ . '/../../../../../');
        passthru("php -S {$address} -t public .htrouter.php");
    }
}