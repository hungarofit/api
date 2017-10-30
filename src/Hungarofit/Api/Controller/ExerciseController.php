<?php

namespace Hungarofit\Api\Controller;


use Phalcon\Db;

class ExerciseController extends BaseController
{
    const MAX_POINTS = 140;

    public function indexAction() {
        return ['exercise' => 'index'];
    }

    public function evaluateAction() {
        $request = $this->request->getJsonRawBody(true);
        return $request;
    }
}