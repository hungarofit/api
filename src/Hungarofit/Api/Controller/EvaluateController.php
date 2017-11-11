<?php

namespace Hungarofit\Api\Controller;



use Hungarofit\Evaluator\Challenge;
use Hungarofit\Evaluator\ChallengeInterface;
use Hungarofit\Evaluator\Exercise;
use Hungarofit\Evaluator\Gender;

class EvaluateController extends BaseController
{
    public function indexAction()
    {
        $points = [];
        $gender = Gender::fromValue($this->request->getPost('gender', 'string'));
        $age = $this->request->getPost('age', 'int');
        $challengeClass = Challenge::class . '\\Hungarofit' . $this->request->getPost('challenge', 'int');
        /** @var ChallengeInterface $challenge */
        $challenge = new $challengeClass($gender, $age);
        $results = $this->request->getPost('results');
        foreach($results as $k => $result) {
            $challenge->setResult(Exercise::fromName($k), $result);
        }
        foreach($challenge->evaluate() as $k => $point) {
            $points[$k] = floatval($point);
        }
        return [
            'points' => $points,
            'rating' => $challenge->rate()->getValue(),
            'ratingName' => $challenge->rate()->getName(),
        ];
    }
}