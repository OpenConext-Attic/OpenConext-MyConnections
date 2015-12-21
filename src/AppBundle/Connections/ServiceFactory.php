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
     * @param string $machineName
     * @param string $displayName
     * @param string $logo
     * @param $routeConnect
     * @param $routeDisconnect
     * @param NamespacedAttributeBag $user
     * @return Service
     */
    public static function create(
        Container $container,
        $machineName,
        $displayName,
        $logo,
        $routeConnect,
        $routeDisconnect,
        NamespacedAttributeBag $user) {

        $service = $container->get('app.connections.service');

        $service->setMachineName($machineName);
        $service->setDisplayName($displayName);
        $service->setLogo($logo);
        $service->setRouteConnect($routeConnect);
        $service->setRouteDisconnect($routeDisconnect);
        $service->setUser($user);

        return $service;
    }

    /**
     * @param Service $service
     * @param $username
     * @param $connectionId
     * @param $establishedAt
     * @return Connection
     */
    public function createDto(
        Service $service,
        $username,
        $connectionId,
        $establishedAt
    ) {
        $dto = new Connection(
            $service->getDisplayName(),
            $service->getMachineName(),
            $service->getLogo(),
            $establishedAt,
            $username,
            $connectionId,
            $service->getDescription(),
            $service->getRouteConnect(),
            $service->getRouteDisconnect()
        );
        return $dto;
    }

    /**
     * @param Repository $repository
     * @param string $username
     * @param string $connectionId
     * @param string $establishedAt
     * @return array
     */
    public function createDtos(
        Repository $repository,
        $username,
        $connectionId,
        $establishedAt
    ) {
        $dtos = [];
        foreach ($repository->getAvailableConnections() as $connection)
        {
            $dtos[] = $this->createDto(
                $connection,
                $username,
                $connectionId,
                $establishedAt
            );
        }
        return $dtos;
    }
}
