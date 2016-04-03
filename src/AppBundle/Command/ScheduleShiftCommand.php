<?php

namespace AppBundle\Command;

use DateTime;
use Domain\Shifts\Entities\DateRange;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Domain\Shifts\Commands\ScheduleShiftCommand as ScheduleShiftDomainCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

class ScheduleShiftCommand extends ContainerAwareCommand
{
    /**
     * @var string
     */
    private $employeeName;

    /**
     * @var DateTime
     */
    private $startDate;

    /**
     * @var DateTime
     */
    private $endDate;

    /**
     * @var array of employee names indexed by id
     */
    private $employees;

    /**
     * @var SymfonyStyle
     */
    private $io;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('shift:schedule')
            ->setDescription('Schedules a shift');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->io->title('Shift Schedule console interface');

        $this->promptForArgs();
        $this->askForConfirmation();
        $this->scheduleCommand();
    }

    /**
     * Returns an array of employeenames indexed by employee id
     *
     * @return array
     */
    private function getEmployees()
    {
        $employees = $this->getContainer()->get('persistence.repositories.doctrine.employee')->findAll();
        $employeesIndex = [];
        foreach ($employees as $employee) {
            $employeesIndex[(string)$employee->getId()] = $employee->getName();
        }

        return $employeesIndex;
    }

    /**
     * Prompts for the employee to schedule
     *
     * @return string
     */
    private function promptForEmployee()
    {
        return $this->io->choice('Please select the employee you want to schedule ', array_values($this->employees));
    }

    /**
     * Prompts for the employee for a start time for the shift
     *
     * @return DateTime
     */
    private function promptForStartDate()
    {
        return new DateTime($this->io->ask('Please enter a start date/time: '));
    }

    /**
     * Prompts for the employee for an end time for the shift
     *
     * @return DateTime
     */
    private function promptForEndDate()
    {
        return new DateTime($this->io->ask('Please enter an end date/time: '));
    }

    /**
     * Prompts the employee for the necessary arguments: employee, start date, end date
     */
    private function promptForArgs()
    {
        $this->employees = $this->getEmployees();
        $this->employeeName = $this->promptForEmployee();
        $this->startDate = $this->promptForStartDate();
        $this->endDate = $this->promptForEndDate();
    }

    /**
     * Asks the employee to confirm before scheduling the shift
     *
     * @return bool
     */
    private function askForConfirmation()
    {
        if (!$this->io->confirm(sprintf(
                'Schedule a shift from %s to %s for employee %s ?',
                $this->startDate->format('l jS \of F Y h:i:s A'),
                $this->endDate->format('l jS \of F Y h:i:s A'),
                $this->employeeName
            )
        )
        ) {
            return false;
        }
    }

    /**
     * Schedules a shift for the chosen employee with the provided start and end dates
     *
     * @throws \Domain\Shifts\Services\Exception\EmployeeNotAvailableException
     * @throws \Domain\Employees\Contracts\Exception\EmployeeNotFoundException
     */
    private function scheduleCommand()
    {
        $command = new ScheduleShiftDomainCommand(
            array_search($this->employeeName, $this->employees),
            new DateRange(
                $this->startDate,
                $this->endDate
            )
        );

        $this->getContainer()->get('domain.service.shift_scheduler')->schedule($command);
        $this->io->success('Shift scheduled !');
    }

}
