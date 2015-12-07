<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Orcid;
use AppBundle\Form\OrcidType;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Rest controller for users.
 *
 * @package AppBundle\Controller
 * @Annotations\Route(defaults={"_format": "json"})
 */
class OrcidRestController extends FOSRestController
{
    /**
     * List all ORCID's from the database. Does not support paging!
     *
     * @ApiDoc(
     *  resource = true,
     *  output="ArrayCollection<AppBundle\Entity\Orcid>",
     *  statusCodes = {
     *      200 = "Returned when successful",
     *      500 = "Returned when there is an internal server error"
     *   }
     * )
     * @Annotations\View()
     *
     * @return array
     */
    public function getOrcidsAction()
    {
        $list = $this->getDoctrine()
            ->getRepository('AppBundle:Orcid')
            ->findAll();

        return $list;
    }

    /**
     * Retrieve a ORCID from database by id (userID).
     *
     * @ApiDoc(
     *   output = "AppBundle\Entity\Orcid",
     *   resource = true,
     *   requirements = {
     *      {
     *          "name" = "id",
     *          "dataType" = "string",
     *          "description" = "UserID"
     *      }
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the user is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param string     $id      the User id
     *
     * @return array
     *
     * @throws NotFoundHttpException when user not exist
     */
    public function getOrcidAction(Request $request, $id)
    {
        /** @var Orcid $orcid */
        $orcid = $this->getDoctrine()
            ->getRepository('AppBundle:Orcid')
            ->find($id);

        if (!$orcid) {
            throw new NotFoundHttpException(
                'User with id: ' . $id . ' not found'
            );
        }

        return $orcid;
    }

    /**
     * Creates a ORCID record from the submitted JSON data.
     *
     * @ApiDoc(
     *   input = "AppBundle\Form\OrcidType",
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the ORCID record is invalid"
     *   }
     * )
     *
     * @param Request $request the request object
     * @return array
     * @throws NotAcceptableHttpException
     */
    public function postOrcidsAction(Request $request)
    {
        $orcid = new Orcid();

        $form = $this->createForm(new OrcidType(), $orcid);
        $form->submit($request);

        if ($form->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();

                $em->persist($orcid);
                $em->flush();

                $this->get('logger')->info('Added ORCID with id ' . $orcid->getId());
                return $this->routeRedirectView('get_orcid', array('id' => $orcid->getId()));
            }
            catch (DBALException $e) {
                throw new NotAcceptableHttpException($e->getMessage());
            }
        }
        return $form->getErrors();
    }

    /**
     * Delete ORCID from the database.
     *
     * @ApiDoc(
     *   resource = true,
     *   requirements = {
     *      {
     *          "name" = "id",
     *          "dataType" = "string",
     *          "description" = "UserID"
     *      }
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the user is not found"
     *   }
     * )

     * @param Request $request
     * @param string $id User ID

     * @return array
     *
     * @throws NotFoundHttpException when ORCID not exist
     */
    public function deleteOrcidAction(Request $request, $id) {

        /** @var Orcid $orcid */
        $orcid = $this->getDoctrine()->getRepository('AppBundle:Orcid')->find($id);

        if (!$orcid) {
            throw new NotFoundHttpException('ORCID with id: ' . $id . ' not found');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($orcid);
        $em->flush();

        $this->get('logger')->info("Removed ORCID with id: " . $orcid->getId());
        return $this->routeRedirectView('get_orcids');
    }
}
