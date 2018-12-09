<?php
/**
 * This file is part of App\Command for code
 *
 * @package    App\Command
 * @file       CreateUserCommand.php
 * @date       09 12 2018 00:31
 * @author     bcalef <benjamin.calef@caudalie.com>
 * @copyright  2018 Caudalie Copyright (c) (https://caudalie.com)
 * @license    proprietary
 */

namespace App\Command;

use App\Entity\AdminUser;
use App\Repository\AdminUserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManager;

class CreateUserCommand extends Command
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var AdminUserRepository
     */
    private $adminUserRepository;

    /**
     * CreateUserCommand constructor.
     *
     * @param EntityManager                $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        AdminUserRepository $adminUserRepository
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->adminUserRepository = $adminUserRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('admin:create-user')
            ->setDescription('Creates a new user admin.')
            ->setHelp('This command allows you to create a user to access admin interface.')
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
            ->addArgument('password', InputArgument::REQUIRED, 'User password');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Creating user admin ' . $input->getArgument('email'),
        ]);

        $adminUser = new AdminUser();
        $adminUser->setEmail($input->getArgument('email'));
        $adminUser->setPassword($this->passwordEncoder->encodePassword($adminUser, $input->getArgument('password')));
        $adminUser->setRoles(['ROLE_ADMIN']);
        $this->adminUserRepository->createNewUser($adminUser);
    }
}
