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
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $provider = $this->get('app.interactionprovider');
        $stateHandler = $this->get('app.saml.state_handler');

        if (!$provider->isSamlAuthenticationInitiated()) {

            $stateHandler->setCurrentRequestUri($request->getUri());
            return $provider->initiateSamlRequest();
        }

        $expectedInResponseTo = $stateHandler->getRequestId();
        $assertion = $provider->processSamlResponse($request);


        return $this->render('AppBundle:default:index.html.twig');
    }
}
