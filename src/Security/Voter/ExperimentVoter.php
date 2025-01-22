<?php

namespace App\Security\Voter;

use App\Entity\Administration\DataWizUser;
use App\Entity\Constant\UserRoles;
use App\Entity\Study\Experiment;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * @extends Voter<string, Experiment>
 */
final class ExperimentVoter extends Voter
{
    public const EDIT = 'EDIT';
    public const REVIEW = 'REVIEW';

    public function __construct(private readonly AccessDecisionManagerInterface $accessDecisionManager) {}

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::REVIEW], true)
            && $subject instanceof Experiment;
    }

    /**
     * @throws \Exception
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof DataWizUser) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        return match ($attribute) {
            self::EDIT => $subject->getOwner() === $user or $this->accessDecisionManager->decide($token, [UserRoles::ADMINISTRATOR]),
            self::REVIEW => $subject->getOwner() === $user or $this->accessDecisionManager->decide($token, [UserRoles::REVIEWER]),
            default => false,
        };
    }
}
