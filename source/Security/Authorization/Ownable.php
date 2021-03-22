<?php


namespace App\Security\Authorization;


use Symfony\Component\Security\Core\User\UserInterface;

interface Ownable
{
    // This interface only serves as marker for the OwnershipFilter
    // Only Entities which implement this interface will be filtered

    public function getOwner();
}