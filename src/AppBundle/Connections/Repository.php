<?php
/**
 * @file
 * Project: orcid
 * File: Repository.php
 */


namespace AppBundle\Connections;

/**
 * Class Repository
 * @package AppBundle\Connections
 */
class Repository
{
    /**
     * @var array
     */
    protected $connections = [];

    public function addConnection(Service $service)
    {
        $this->connections[$service->getMachineName()] = $service;
    }

    public function removeConnection($machineName)
    {
        if ($this->hasConnection($machineName)) {
            unset($this->connections[$machineName]);
        }
    }

    public function hasConnection($machineName)
    {
        return array_key_exists($machineName, $this->connections);
    }

    public function getAvailableConnections()
    {
        return $this->connections;
    }
}
