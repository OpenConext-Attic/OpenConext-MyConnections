<?php
/**
 * @file
 * Project: orcid
 * File: Service.php
 */


namespace AppBundle\Connections;

use Symfony\Component\HttpFoundation\Session\Attribute\NamespacedAttributeBag;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class Service
{
    /**
     * @var string
     */
    protected $machineName;
    /**
     * @var string
     */
    protected $displayName;
    /**
     * @var string
     */
    protected $logo;
    /**
     * @var string
     */
    protected $routeConnect;
    /**
     * @var
     */
    protected $routeDisconnect;

    /**
     * @var NamespacedAttributeBag
     */
    protected $user;

    /**
     * @var Container
     */
    protected $container;

    /**
     * Service constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return string
     */
    public function getMachineName()
    {
        return $this->machineName;
    }

    /**
     * @param string $machineName
     */
    public function setMachineName($machineName)
    {
        $this->machineName = $machineName;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->container
            ->get('translator')
                ->trans(
                    'service_' .
                    $this->getMachineName() .
                    '_description'
                );
    }

    /**
     * @return NamespacedAttributeBag
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param NamespacedAttributeBag $user
     */
    public function setUser(NamespacedAttributeBag $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getRouteDisconnect()
    {
        return $this->routeDisconnect;
    }

    /**
     * @param mixed $routeDisconnect
     */
    public function setRouteDisconnect($routeDisconnect)
    {
        $this->routeDisconnect = $routeDisconnect;
    }

    /**
     * @return string
     */
    public function getRouteConnect()
    {
        return $this->routeConnect;
    }

    /**
     * @param string $routeConnect
     */
    public function setRouteConnect($routeConnect)
    {
        $this->routeConnect = $routeConnect;
    }
}