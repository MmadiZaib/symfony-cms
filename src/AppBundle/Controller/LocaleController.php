<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class LocaleController extends Controller
{
    /**
     * Redirects user to based their referer
     * @Route("/{_locale}/locale", name="app_set_locale")
     * @Method("GET")
     * @return RedirectResponse
     */
    public function setLocaleAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');

        //if referrer exists, redirect to referer
        $referer = $request->headers->get('referer');
        if ($referer) {
            return $this->redirect($referer);
        }
        //if logged in, redirect to dashboard
        elseif ($auth_checker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('dashboard');
        }
        else {
            return $this->redirect('/');
        }

    }
}
