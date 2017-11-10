<?php

namespace Hungarofit\Api\Controller;


use Hungarofit\Evaluator\Exercise\AerobBike12min;
use Hungarofit\Evaluator\Exercise\AerobRun12min;
use Hungarofit\Evaluator\Exercise\AerobRun1mile;
use Hungarofit\Evaluator\Exercise\AerobRun1mile5;
use Hungarofit\Evaluator\Exercise\AerobRun2km;
use Hungarofit\Evaluator\Exercise\AerobRun2mile;
use Hungarofit\Evaluator\Exercise\AerobRun6min;
use Hungarofit\Evaluator\Exercise\AerobSwim12min;
use Hungarofit\Evaluator\Exercise\AerobSwim500m;
use Hungarofit\Evaluator\Exercise\Motor3Jump;
use Hungarofit\Evaluator\Exercise\Motor3Situp;
use Hungarofit\Evaluator\Exercise\Motor3Torso;
use Hungarofit\Evaluator\Exercise\Motor4Jump;
use Hungarofit\Evaluator\Exercise\Motor4Pushup;
use Hungarofit\Evaluator\Exercise\Motor4Situp;
use Hungarofit\Evaluator\Exercise\Motor4Torso;
use Hungarofit\Evaluator\Exercise\Motor6Jump;
use Hungarofit\Evaluator\Exercise\Motor6Pushup;
use Hungarofit\Evaluator\Exercise\Motor6Situp;
use Hungarofit\Evaluator\Exercise\Motor6Throwdouble;
use Hungarofit\Evaluator\Exercise\Motor6Throwsingle;
use Hungarofit\Evaluator\Exercise\Motor6Torso;
use Hungarofit\Evaluator\ExerciseInterface;

class MasterController extends BaseController
{
    const MAX_POINTS = 140;

    public function indexAction()
    {
        $challenges = [
            '6' => [
                'name' => 'Hungarofit 6+1',
                'aerob' => [
                    AerobBike12min::get()->getKey(),
                    AerobRun1mile::get()->getKey(),
                    AerobRun1mile5::get()->getKey(),
                    AerobRun2km::get()->getKey(),
                    AerobRun2mile::get()->getKey(),
                    AerobRun6min::get()->getKey(),
                    AerobRun12min::get()->getKey(),
                    AerobSwim12min::get()->getKey(),
                    AerobSwim500m::get()->getKey(),
                ],
                'motor' => [
                    Motor6Situp::get()->getKey(),
                    Motor6Jump::get()->getKey(),
                    Motor6Pushup::get()->getKey(),
                    Motor6Torso::get()->getKey(),
                    Motor6Throwdouble::get()->getKey(),
                    Motor6Throwsingle::get()->getKey(),
                ],
            ],
            '4' => [
                'name' => 'Hungarofit 4+1',
                'aerob' => [
                    AerobBike12min::get()->getKey(),
                    AerobRun1mile::get()->getKey(),
                    AerobRun1mile5::get()->getKey(),
                    AerobRun2km::get()->getKey(),
                    AerobRun2mile::get()->getKey(),
                    AerobRun6min::get()->getKey(),
                    AerobRun12min::get()->getKey(),
                    AerobSwim12min::get()->getKey(),
                    AerobSwim500m::get()->getKey(),
                ],
                'motor' => [
                    Motor4Situp::get()->getKey(),
                    Motor4Jump::get()->getKey(),
                    Motor4Pushup::get()->getKey(),
                    Motor4Torso::get()->getKey(),
                ],
            ],
        ];
        $exercises = [];
        /** @var ExerciseInterface $x */
        foreach ([
                     AerobBike12min::get(),
                     AerobRun1mile::get(),
                     AerobRun1mile5::get(),
                     AerobRun2km::get(),
                     AerobRun2mile::get(),
                     AerobRun6min::get(),
                     AerobRun12min::get(),
                     AerobSwim12min::get(),
                     AerobSwim500m::get(),
                     Motor4Situp::get(),
                     Motor4Jump::get(),
                     Motor4Pushup::get(),
                     Motor4Torso::get(),
                     Motor6Situp::get(),
                     Motor6Jump::get(),
                     Motor6Pushup::get(),
                     Motor6Torso::get(),
                     Motor6Throwdouble::get(),
                     Motor6Throwsingle::get(),
                 ] as $x) {
            $exercises[$x->getName()] = [
                'name' => $x->getName(),
                'key' => $x->getKey(),
                'age' => [
                    'min' => $x->getMinAge(),
                ],
                'unit' => [
                    'result' => $x->getResultUnit()->getValue(),
                    'exercise' => $x->getResultUnit()->getValue(),
                ],
            ];
        }
        return [
            'challenges' => $challenges,
            'exercises' => $exercises,
        ];
    }
}