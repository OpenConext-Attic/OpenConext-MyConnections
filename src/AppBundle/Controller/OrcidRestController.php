<?php
namespace AppBundle\Controller;

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
     *
     * @return array
     */
    public function getOrcidsAction()
    {
        $list = $this->getDoctrine()
            ->getRepository('AppBundle:Orcid')
            ->findAll();

        return $this->view($list);
    }
}
