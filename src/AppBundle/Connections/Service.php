<?php
/**
 * @file
 * Project: orcid
 * File: Service.php
 */


namespace AppBundle\Connections;

use Symfony\Component\HttpFoundation\Session\Attribute\NamespacedAttributeBag;

class Service
{
    /**
     * @var string
     */
    protected $machine_name;
    /**
     * @var string
     */
    protected $display_name;
    /**
     * @var string
     */
    protected $logo;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $route;
    /**
     * @var NamespacedAttributeBag
     */
    protected $user;

    /**
     * @return string
     */
    public function getMachineName()
    {
        return $this->machine_name;
    }

    /**
     * @param string $machine_name
     */
    public function setMachineName($machine_name)
    {
        $this->machine_name = $machine_name;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * @param string $display_name
     */
    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;
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
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
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
}