<?php
/**
 * @file
 * Project: orcid
 * File: ServiceFactory.php
 */


namespace AppBundle\Connections;

use Symfony\Component\HttpFoundation\Session\Session;

class OrcidServiceFactory
{

    /**
     * @return Service
     */
    public static function create(Session $session) {

        $service = new Service();

        $service->setMachineName('orcid');
        $service->setDisplayName('ORCID');
        $service->setLogo('/images/orcid.png');
        $service->setDescription('
            <span class="service">ORCID</span> is a nonproprietary alphanumeric code to uniquely identify scientific
            and other academic authors. This addresses the problem that a particular author\'s contributions to the
            scientific literature or publications in the humanities can be hard to recognize as most personal names
            are not unique, they can change (such as with marriage), have cultural differences in name order,
            contain inconsistent use of first-name abbreviations and employ different writing systems.
        ');
        $service->setRoute('orcid_authorize');

        $user = $session->get('user', NULL);
        if (is_array($user) && !empty($user)) {
            $service->setUid($user['eduPPN']);
        }

        return $service;
    }
}
