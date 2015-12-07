<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
        $user = $this->get('session')->get('user');

        if ($user === NULL || !is_array($user) || empty($user))
        {
            return $this->redirectToRoute('login');
        }

        if (!empty($user['displayName']))
        {
            $name = $user['displayName'];
        } else {
            $name = $user['uid'];
        }

        return $this->render('AppBundle:default:index.html.twig', [ 'name' => $name ]);
    }

    /**
     * Login page.
     *
     * @Route("/login", name="login")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        return $this->render('AppBundle:default:login.html.twig', [ 'name' => 'Guest' ]);
    }

    /**
     * Initiate SAML auth request
     *
     * @Route("/auth", name="saml_auth")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function authAction(Request $request)
    {
        $provider = $this->get('app.interactionprovider');
        $stateHandler = $this->get('app.saml.state_handler');

        $stateHandler->setCurrentRequestUri($request->getUri());
        return $provider->initiateSamlRequest();
    }

    /**
     * @Route("/auth_error", name="auth_error")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function authErrorAction(Request $request)
    {
        return $this->render('AppBundle:default:auth_error.html.twig', [ 'name' => 'Guest' ]);
    }

    /**
     * Logout
     *
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        $this->get('session')->clear();
        return $this->redirectToRoute('index');
    }
}
