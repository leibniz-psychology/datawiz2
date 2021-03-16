<?php


namespace App\View\Controller;


use App\Crud\Crudable;
use App\Domain\Model\Administration\DataWizUser;
use App\Domain\Model\Study\Experiment;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\VarDumper\Cloner\Data;


class AdministrationController extends DataWizController
{
    public function profileAction(Security $security): Response
    {
        return $this->render('Pages/Administration/profile.html.twig', [
            'currentUser' => $security->getUser()
        ]);
    }

}