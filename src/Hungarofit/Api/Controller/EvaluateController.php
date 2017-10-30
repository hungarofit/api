<?php

namespace Hungarofit\Api\Controller;



class EvaluateController extends BaseController
{
    public function indexAction()
    {
        $request = $this->request->getJsonRawBody(true);
        return $request;
    }
}