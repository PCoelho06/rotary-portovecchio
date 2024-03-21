<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/a-propos', name: 'club_')]
class ClubController extends AbstractController
{
    #[Route('/histoire', name: 'history')]
    public function history(): Response
    {
        return $this->render('club/history.html.twig');
    }

    #[Route('/causes', name: 'causes')]
    public function causes(): Response
    {
        return $this->render('club/causes.html.twig');
    }

    #[Route('/membres', name: 'members')]
    public function members(): Response
    {
        return $this->render('club/members.html.twig');
    }
}
