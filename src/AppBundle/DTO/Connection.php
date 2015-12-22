<?php
/**
 * @file
 * Project: orcid
 * File: Connection.php
 */


namespace AppBundle\DTO;

/**
 * Class Connection
 * @package AppBundle\DTO
 */
class Connection
{
    /**
     * @var string URI of image logo
     */
    public $logo;
    /**
     * @var string Datetime string in displayable format
     */
    public $established_at;
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $connection_id;
    /**
     * @var string
     */
    public $description;
    /**
     * @var string router name to redirect when connecting.
     */
    public $route;
    /**
     * @var string
     */
    public $display_name;
    /**
     * @var string
     */
    public $machine_name;

    /**
     * Connection constructor.
     * @param string $display_name
     * @param string $machine_name
     * @param string $logo
     * @param string $established_at
     * @param string $username
     * @param string $connection_id
     * @param string $description
     * @param string $route_connect
     * @param string $route_disconnect
     */
    public function __construct(
        $display_name,
        $machine_name,
        $logo,
        $established_at,
        $username,
        $connection_id,
        $description,
        $route_connect,
        $route_disconnect
    ) {
        $this->display_name = $display_name;
        $this->machine_name = $machine_name;
        $this->logo = $logo;
        $this->established_at = $established_at;
        $this->username = $username;
        $this->connection_id = $connection_id;
        $this->description = $description;
        $this->route_connect = $route_connect;
        $this->route_disconnect = $route_disconnect;
    }
}
