<?php

namespace App\Command;

use App\Domain\Model\Administration\DataWizUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetAdminCommand extends Command
{
    protected static $defaultName = 'dw:add-user-role';
    private EntityManagerInterface $em;


    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }


    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to add a role to a user')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.')
            ->addArgument('role', InputArgument::REQUIRED, 'The new role of the user: e.g. ROLE_ADMIN, ROLE_MODERATOR');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');
        $role = $input->getArgument('role');
        $output->writeln([
                             "============================================================",
                             "execute pax:add-user-role with email: $email and role: $role",
                         ]);
        $user = $this->em->getRepository(DataWizUser::class)->findOneBy(['email' => $email]);
        if ($user !== null && ($role === 'ROLE_ADMIN' || $role === 'ROLE_MODERATOR')) {
            $output->writeln(["user with email: ".$user->getEmail().' found uuid: '.$user->getId()]);
            $roles = $user->getRoles();
            if (!in_array($role, $roles)) {
                $roles[] = $role;
                $user->setRoles($roles);
                $this->em->persist($user);
                $this->em->flush();
                $output->writeln([
                                     "Role set",
                                     "============================================================",
                                 ]);

                return Command::SUCCESS;
            }
        }

        return Command::INVALID;
    }
}