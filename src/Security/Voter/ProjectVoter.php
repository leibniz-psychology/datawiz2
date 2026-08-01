<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Administration\DataWizUser;
use App\Entity\Constant\UserRoles;
use App\Entity\Project\Project;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * @extends Voter<string, Project>
 */
final class ProjectVoter extends Voter
{
    public const string EDIT = 'EDIT';
    public const string REVIEW = 'REVIEW';

    public function __construct(private readonly AccessDecisionManagerInterface $accessDecisionManager)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::REVIEW], true)
            && $subject instanceof Project;
    }

    /**
     * @throws \Exception
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof DataWizUser) {
            $vote?->addReason('The user is not logged in');

            return false;
        }

        return match ($attribute) {
            self::EDIT => $subject->getOwner() === $user or $this->accessDecisionManager->decide($token, [UserRoles::ADMINISTRATOR]),
            self::REVIEW => $subject->getOwner() === $user or $this->accessDecisionManager->decide($token, [UserRoles::REVIEWER]),
            default => false,
        };
    }
}
