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
    private $username;

    /**
     * @var DateTime
     */
    private $startDate;

    /**
     * @var DateTime
     */
    private $endDate;

    /**
     * @var array of user names indexed by id
     */
    private $users;

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
     * Returns an array of usernames indexed by user id
     * 
     * @return array
     */
    private function getUsers()
    {
        $users = $this->getContainer()->get('persistence.repositories.doctrine.user')->findAll();
        $usersIndex = [];
        foreach ($users as $user) {
            $usersIndex[(string) $user->getId()] = $user->getName();       
        }

        return $usersIndex;
    }

    /**
     * Prompts for the user to schedule 
     * 
     * @return string
     */
    private function promptForUser()
    {
        return $this->io->choice('Please select the employee you want to schedule ', array_values($this->users));
    }

    /**
     * Prompts for the user for a start time for the shift
     *
     * @return DateTime
     */    
    private function promptForStartDate()
    {
        return new DateTime($this->io->ask('Please enter a start date/time: '));
    }

    /**
     * Prompts for the user for an end time for the shift
     *
     * @return DateTime
     */
    private function promptForEndDate()
    {
        return new DateTime($this->io->ask('Please enter an end date/time: '));
    }

    /**
     * Prompts the user for the necessary arguments: user, start date, end date
     */    
    private function promptForArgs()
    {
        $this->users = $this->getUsers();
        $this->username = $this->promptForUser();
        $this->startDate = $this->promptForStartDate();
        $this->endDate = $this->promptForEndDate();
    }

    /**
     * Asks the user to confirm before scheduling the shift  
     * 
     * @return bool
     */
    private function askForConfirmation()
    {
        if (!$this->io->confirm(sprintf(
                'Schedule a shift from %s to %s for user %s ?',
                $this->startDate->format('l jS \of F Y h:i:s A'),
                $this->endDate->format('l jS \of F Y h:i:s A'),
                $this->username
            )
        )) {
            return false;
        }
    }

    /**
     * Schedules a shift for the chosen user with the provided start and end dates
     * 
     * @throws \Domain\Shifts\Services\Exception\UserNotAvailableException
     * @throws \Domain\Users\Contracts\Exception\UserNotFoundException
     */
    private function scheduleCommand()
    {
        $command = new ScheduleShiftDomainCommand(
            array_search($this->username, $this->users),
            new DateRange(
                $this->startDate,
                $this->endDate    
            )
        );
        
        $this->getContainer()->get('domain.service.shift_scheduler')->schedule($command);
        $this->io->success('Shift scheduled !');
    }

}
