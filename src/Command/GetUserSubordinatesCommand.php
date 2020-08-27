<?php
declare(strict_types=1);

namespace UserRoleHierarchy\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserRoleHierarchy\Entity\User;
use UserRoleHierarchy\Service\UserRoleService;

class GetUserSubordinatesCommand extends Command
{
    private const COMMAND_NAME = 'get-user-subordinates';

    private UserRoleService $userRoleService;

    public function __construct(UserRoleService $userRoleService)
    {
        parent::__construct(self::COMMAND_NAME);
        $this->userRoleService = $userRoleService;
    }

    public function configure(): void
    {
        $this->setName('get-user-subordinates')
            ->setDescription('Retrieve the details of a user')
            ->addArgument('user-id', InputArgument::REQUIRED, 'The ID of the user to retrieve');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $userId = (int) $input->getArgument('user-id');

        $user = $this->userRoleService->getUserById($userId);

        if (!$user instanceof User) {
            return 1;
        }

        $output->write(json_encode($this->userRoleService->getUserSubordinates($user)));

        return 0;
    }
}