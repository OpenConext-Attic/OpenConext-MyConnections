<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Connection;
use Doctrine\DBAL\DBALException;
use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class OrcidController
 * @package AppBundle\Controller
 */
class OrcidController extends Controller
{
    /**
     * Orcid OAuth authentication request.
     *
     * @see http://members.orcid.org/api/tutorial-retrieve-orcid-id-curl-v12-and-earlier
     *
     * @Route("/orcid/authorize", name="orcid_authorize")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function authorizeAction(Request $request)
    {
        if (!$this->isLoggedIn()) {
            return $this->redirectToRoute('index');
        }

        $params = [
            'client_id' => $this->getParameter('orcid_client_id'),
            'response_type' => 'code',
            'scope' => '/authenticate',
            'redirect_uri' => $this->generateUrl('orcid_consume', [] , true)
        ];
        $endpoint =
            $this->getParameter('orcid_authorize_endpoint') .
            '?' .
            http_build_query($params);

        return $this->redirect($endpoint);
    }

    /**
     * @see http://members.orcid.org/api/tutorial-retrieve-orcid-id-curl-v12-and-earlier
     * @Route("/orcid/consume", name="orcid_consume")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function consumeAction(Request $request)
    {
        if (!$this->isLoggedIn()) {
            return $this->redirectToRoute('index');
        }

        // Did we get an Oauth token?
        $code = $request->get('code', NULL);
        if (NULL === $code || empty($code)) {
            $this->get('logger')
                ->addError(
                  'Did not get OAuth token from authorize endpoint.'
                );
            return $this->redirectToRoute('auth_error');
        }

        // Request for authorization code
        $token_endpoint = $this->getParameter('orcid_token_endpoint');
        $form_params = [
            'client_id' => $this->getParameter('orcid_client_id'),
            'client_secret' => $this->getParameter('orcid_client_secret'),
            'grant_type' => 'authorization_code',
            'code' => $request->get('code'),
            'redirect_uri' => $this->generateUrl('orcid_consume', [], true)
        ];

        $client = $this->get('app.guzzle');
        $response = $client->request('POST', $token_endpoint, [
            'form_params' => $form_params,
            'headers' => [ 'Accept' => 'application/json' ]
        ]);

        // Authentication error?
        if ($response->getStatusCode() !== 200) {
            $this->get('logger')
                ->addError(
                    'Received responsecode ' . $response->getStatusCode() .
                    ' from oricid token endpoint'
                );
            return $this->redirectToRoute('auth_error');
        }

        $data = json_decode($response->getBody());

        $connection = new Connection();
        $connection->setService('orcid');
        $connection->setCuid($data->orcid);
        $connection->setUid($this->get('app.user')->get('eduPPN'));
        $connection->setEstablishedAt(new \DateTime());

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($connection);
            $em->flush();
        } catch (DBALException $e) {
            $this->get('logger')
                ->addError(
                    'Unable to save ORCID id with message ' .
                    $e->getMessage()
                );
            return $this->redirectToRoute('auth_error');
        }
        return $this->redirectToRoute('index');
    }

    /**
     * Orcid OAuth disconnect request.
     *
     * @Route("/orcid/disconnect", name="orcid_disconnect")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function disconnectAction(Request $request)
    {
        if (!$this->isLoggedIn()) {
            return $this->redirectToRoute('index');
        }

        $connection = $this->getDoctrine()
            ->getRepository('AppBundle:Connection')
            ->find(
                [
                    'service' => 'orcid',
                    'uid' => $this->get('app.user')->get('eduPPN')
                ]
            );

        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($connection);
            $em->flush();
        } catch (DBALException $e) {
            $this->get('logger')
                ->addError(
                    'Unable to remove connection for user ' .
                    $this->get('app.user')->get('eduPPN') .
                    ' and service orcid'
                );
        }

        return $this->redirectToRoute('index');
    }

    /**
     * @return bool
     */
    private function isLoggedIn()
    {
        return ($this->get('app.user')->has('nameId'));
    }
}
