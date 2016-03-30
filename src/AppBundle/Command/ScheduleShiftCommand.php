<?php

namespace AppBundle\Command;

use Domain\Shifts\Commands\ScheduleShiftCommand as ScheduleShiftDomainCommand;
use Domain\Shifts\Entities\DateRange;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DateTime;

class ScheduleShiftCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('shift:schedule')
            ->setDescription('Schedules a shift')
            ->addArgument('user', InputArgument::REQUIRED)
            ->addArgument('start', InputArgument::REQUIRED)
            ->addArgument('end', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = new ScheduleShiftDomainCommand(
            $input->getArgument('user'),
            new DateRange(
                new DateTime($input->getArgument('start')),    
                new DateTime($input->getArgument('end'))    
            )
        );
        
        $this->getContainer()->get('domain.service.shift_scheduler')->schedule($command);

        $output->writeln('done');
    }    
}
