<?php

namespace App\View\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class AdministrationController extends DataWizController
{
    public function profileAction(Security $security): Response
    {
        return $this->render('Pages/Administration/profile.html.twig', [
            'currentUser' => $security->getUser(),
        ]);
    }
}
