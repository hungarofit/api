<?php

namespace Hungarofit\Api\Console\Task;


class MainTask extends BaseTask
{
    public function indexAction()
    {
        $this->dispatcher->forward([
            'task' => 'main',
            'action' => 'help',
        ]);
    }
}