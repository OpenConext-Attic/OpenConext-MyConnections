<?php
/**
 * @file
 * Project: orcid
 * File: ServiceFactory.php
 */


namespace AppBundle\Connections;

use AppBundle\DTO\Connection;
use Symfony\Component\HttpFoundation\Session\Attribute\NamespacedAttributeBag;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class ServiceFactory
{

    /**
     * @param Container $container
     * @param string $machine_name
     * @param string $display_name
     * @param string $logo
     * @param $route_connect
     * @param $route_disconnect
     * @param NamespacedAttributeBag $user
     * @return Service
     */
    public static function create(
        Container $container,
        $machine_name,
        $display_name,
        $logo,
        $route_connect,
        $route_disconnect,
        NamespacedAttributeBag $user) {

        $service = $container->get('app.connections.service');

        $service->setMachineName($machine_name);
        $service->setDisplayName($display_name);
        $service->setLogo($logo);
        $service->setRouteConnect($route_connect);
        $service->setRouteDisconnect($route_disconnect);
        $service->setUser($user);

        return $service;
    }

    /**
     * @param Service $service
     * @param $username
     * @param $connection_id
     * @param $established_at
     * @return Connection
     */
    public function createDto(
        Service $service,
        $username,
        $connection_id,
        $established_at
    ) {
        $dto = new Connection(
            $service->getDisplayName(),
            $service->getMachineName(),
            $service->getLogo(),
            $established_at,
            $username,
            $connection_id,
            $service->getDescription(),
            $service->getRouteConnect(),
            $service->getRouteDisconnect()
        );
        return $dto;
    }

    /**
     * @param Repository $repository
     * @param string $username
     * @param string $connection_id
     * @param string $established_at
     * @return array
     */
    public function createDtos(
        Repository $repository,
        $username,
        $connection_id,
        $established_at
    ) {
        $dtos = [];
        foreach ($repository->getAvailableConnections() as $connection)
        {
            $dtos[] = $this->createDto(
                $connection,
                $username,
                $connection_id,
                $established_at
            );
        }
        return $dtos;
    }
}
