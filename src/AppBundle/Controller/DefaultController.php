<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Connection;
use AppBundle\Connections\Service;

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
        $connections = [];

        $repository = $this->get('app.service.repository');

        $user = $this->get('app.user');
        if (!$user->has('nameId')) {
            return $this->redirectToRoute('login');
        }

        // Default name...
        $nameId = $user->get('nameId');
        $name = $nameId['Value'];

        if ($user->has('displayName')) {
            $name = $user->get('displayName');
        }

        if ($user->has('eduPPN')) {
            $uid = $user->get('eduPPN');

            $connected = $this->getDoctrine()
                ->getRepository('AppBundle:Connection')
                ->findAll(
                    [
                        'uid' => $uid
                    ]
                );

            /** @var Connection $c */
            foreach ($connected as $c) {
                try {
                    /** @var Service $service */
                    $service = $this->get('app.service.' . $c->getService());

                    // Remove service from available services
                    // since its already connected!
                    $repository->removeConnection($c->getService());

                    $dto = $this->get('app.service.factory')
                        ->createDto(
                            $service,
                            $uid,
                            $c->getCuid(),
                            $c->getEstablishedAt()
                        );
                    $connections[] = $dto;

                } catch(\Exception $e) {
                    $this->get('logger')
                        ->addError(
                            'Service ' .
                            $c->getService() .
                            ' unavailable'
                        );
                }
            }
        }

        $available_connections =
            $this->get('app.service.factory')
                ->createDtos(
                    $repository,
                    NULL,
                    NULL,
                    NULL
                );

        return $this->render(
            'AppBundle:default:index.html.twig',
            [
                'name' => $name,
                'connections' => $connections,
                'available_connections' => $available_connections
            ]
        );
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
        $repository = $this->get('app.service.repository');

        $available_connections =
            $this->get('app.service.factory')
                ->createDtos(
                    $repository,
                    NULL,
                    NULL,
                    NULL
                );

        return $this->render(
            'AppBundle:default:login.html.twig',
            [
                'name' => 'Guest',
                'connections' => [],
                'available_connections' => $available_connections
            ]
        );
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
        $repository = $this->get('app.service.repository');

        $available_connections =
            $this->get('app.service.factory')
                ->createDtos(
                    $repository,
                    NULL,
                    NULL,
                    NULL
                );

        return $this->render(
            'AppBundle:default:auth_error.html.twig',
            [
                'name' => 'Guest',
                'connections' => [],
                'available_connections' =>  $available_connections
            ]
        );
    }

    /**
     * Logout
     *
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        $user = $this->get('app.user');
        $user->clear();

        return $this->redirectToRoute('index');
    }
}
