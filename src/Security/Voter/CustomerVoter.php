<?php

namespace App\Security\Voter;

use App\Constants\Constant;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        // Vérifie que l'action demandée doit déclencher le voter
        return in_array($attribute, ["CUSTOMER_EDIT", "CUSTOMER_VIEW"])
            && $subject instanceof \App\Entity\Customer;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // Si l'utilisateur n'est pas authentifié, accès refusé
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Vérifie la permission selon l'action demandée (éditer, regarder)
        return match ($attribute) {
            "CUSTOMER_EDIT" => $this->checkRight($user, $subject),
            "CUSTOMER_VIEW" => $this->checkRight($user, $subject),
            default => false,
        };

    }

    protected function checkRight($user, $subject): bool
    {
        // Si l'utilisateur est un admin, ou s'il est customer et consulte ses propres données, accès autorisé
        if($user->getRoles() === Constant::ROLE_ADMIN || $user->getId() === $subject->getId())
        {
            return true;
        }
        return false;
    }
}
