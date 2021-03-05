<?php

namespace App\Security\Authentication;

use App\Crud\Crudable;
use App\Domain\Model\Administration\DataWizUser;
use Monolog\Logger;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class DevelopmentUserProvider implements UserProviderInterface
{
    /**
     * @var Crudable
     */
    private $crud;
    /**
     * @var Logger
     */
    private $log;

    public function __construct(Crudable $crud, Logger $log)
    {
        $this->crud = $crud;
        $this->log = $log;
    }

    /**
     * If you're not using these features, you do not need to implement
     * this method.
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername(string $username)
    {
        /**
         * @var DataWizUser
         */
        $user = $this->crud->readForAll(DataWizUser::class)[0];
        $this->log->debug('You found'.$user->getUsername());

        return $user;
    }

    /**
     * Refreshes the user after being reloaded from the session.
     *
     * When a user is logged in, at the beginning of each request, the
     * User object is loaded from the session and then this method is
     * called. Your job is to make sure the user's data is still fresh by,
     * for example, re-querying for fresh User data.
     *
     * If your firewall is "stateless: true" (for a pure API), this
     * method is not called.
     *
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
    }

    /**
     * Tells Symfony to use this provider for this User class.
     */
    public function supportsClass(string $class)
    {
        return DataWizUser::class === $class;
    }
}
