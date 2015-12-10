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

    public function removeConnection($machine_name)
    {
        if ($this->hasConnection($machine_name)) {
            unset($this->connections[$machine_name]);
        }
    }

    public function hasConnection($machine_name)
    {
        return array_key_exists($machine_name, $this->connections);
    }

    public function getAvailableConnections()
    {
        return $this->connections;
    }
}
