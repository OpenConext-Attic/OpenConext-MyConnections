<?php
/**
 * @file
 * Project: orcid
 * File: ServiceFactory.php
 */


namespace AppBundle\Connections;

use Symfony\Component\HttpFoundation\Session\Attribute\NamespacedAttributeBag;

class ServiceFactory
{

    /**
     * @param string $machine_name
     * @param string $display_name
     * @param string $logo
     * @param string $description
     * @param string $route
     * @param NamespacedAttributeBag $user
     * @return Service
     */
    public static function create(
        $machine_name,
        $display_name,
        $logo,
        $description,
        $route,
        NamespacedAttributeBag $user) {

        $service = new Service();

        $service->setMachineName($machine_name);
        $service->setDisplayName($display_name);
        $service->setLogo($logo);
        $service->setDescription($description);
        $service->setRoute($route);
        $service->setUser($user);

        return $service;
    }
}
