<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route(path: '/editer-mot-de-passe', name: 'user_edit_password')]
    public function editPassword(): Response
    {
        return $this->render('user/edit-password.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
