<?php

namespace AppBundle\Controller;

use AppBundle\Persistence\Doctrine\DoctrineShiftRepository;
use AppBundle\Persistence\Doctrine\DoctrineUserRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Domain\Shifts\Commands\ScheduleShiftCommand;
use Domain\Shifts\Entities\DateRange;
use Domain\Shifts\Services\ShiftScheduler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShiftController extends Controller
{
    /**
     * @Route("/shifts", name="shifts_list")
     */
    public function indexAction(Request $request)
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
        $shiftScheduler = new ShiftScheduler(
            new DoctrineShiftRepository(
                new EntityManager(
                    $connection,
                    $config,
                    $eventManger
                )
            ),
            new DoctrineUserRepository(
                new EntityManager(
                    $connection,
                    $config,
                    $eventManger
                )                
            ),
            new EventDispatcher()
        );
    }    
}
