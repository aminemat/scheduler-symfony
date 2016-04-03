<?php

namespace AppBundle\Controller;

use DateTime;
use Domain\Shifts\Commands\GetShiftsCommand;
use Domain\Shifts\Commands\ScheduleShiftCommand;
use Domain\Shifts\Entities\DateRange;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ShiftController extends Controller
{
    /**
     * @Route("/shifts.json", name="shifts-list")
     */
    public function shiftsAction()
    {
        $shiftProvider = $this->get('domain.service.shift_provider');

        $shifts = $shiftProvider->getShifts(
            new GetShiftsCommand(
                new DateRange(
                    new DateTime('today 8:30am CST'),
                    new DateTime('today 5pm CST')
                )                
            )
        );
        
        $fractal = new Manager();

        return new JsonResponse(
            $fractal->createData(new Collection($shifts, $this->get('transformers.shift')))->toArray()
        );
    }
    
    /**
     * @Route("/schedule-shift", name="schedule-shift")
     */
    public function scheduleShiftAction(Request $request)
    {
        $shiftScheduler = $this->get('domain.service.shift_scheduler');

        $shiftScheduler->schedule(
            new ScheduleShiftCommand(
                '006194cc-9cc7-454f-8243-e418557346d8',
                new DateRange(
                    new DateTime('today 8am CST'),
                    new DateTime('today 1pm CST')
                )
            )
        );
        
        return new Response();
    }

    /**
     * @Route("/", name="homepage")
     */
    public function badIndexAction(Request $request)
    {
//        $shiftScheduler = new ShiftScheduler(
//            new DoctrineShiftRepository(
//                new EntityManager(
//                    $connection,
//                    $config,
//                    $eventManger
//                )
//            ),
//            new DoctrineEmployeeRepository(
//                new EntityManager(
//                    $connection,
//                    $config,
//                    $eventManger
//                )                
//            ),
//            new EventDispatcher()
//        );
    }    
}
