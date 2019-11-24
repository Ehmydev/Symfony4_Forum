<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function login(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $lastLogin = $utils->getLastUsername();

        return $this->render('pages/login.html.twig', [
            'last_username' => $lastLogin,
            'error' => $error,
<<<<<<< HEAD
            'current_menu' => 'login',
        ]);
    }
=======
        ]);
    }

    public function register(): Response
    {
        return $this->render('pages/register.html.twig');
    }
>>>>>>> 84f10b5d59b15bcaf45015c9fed2102d2455e00d
}
