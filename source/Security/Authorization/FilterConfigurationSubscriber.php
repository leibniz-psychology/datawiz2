<?php


namespace App\Security\Authorization;


use App\Domain\Model\Administration\DataWizUser;
use App\Kernel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class FilterConfigurationSubscriber implements EventSubscriberInterface
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest() {
        /** @var DataWizUser $currentUser */
        $currentUser = $this->security->getUser();

        $filter = $this->entityManager
            ->getFilters()
            ->enable('ownership');

        if ($currentUser != null) {
            $filter->setParameter('currentUserId', $currentUser->getId(), 'uuid');
        }
    }
}