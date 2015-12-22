<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="connection",
 *     indexes={@ORM\Index(name="value_idx", columns={"cuid"})}
 * )
 * @ExclusionPolicy("all")
 */
class Connection
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     name="uid",
     *     nullable=false
     * )
     * @Expose()
     */
    protected $uid;

    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     name="service",
     *     nullable=false
     * )
     * @Expose()
     */
    protected $service;

    /**
     * @var string
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     name="cuid",
     *     nullable=false
     * )
     * @Expose()
     */
    protected $cuid;
    /**
     * @var string
     * @ORM\Column(
     *     type="datetime",
     *     name="established_at",
     *     nullable=false
     * )
     * @Expose()
     */
    protected $established_at;

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getCuid()
    {
        return $this->cuid;
    }

    /**
     * @param string $cuid
     */
    public function setCuid($cuid)
    {
        $this->cuid = $cuid;
    }

    /**
     * @return string
     */
    public function getEstablishedAt()
    {
        return $this->established_at;
    }

    /**
     * @param string $established_at
     */
    public function setEstablishedAt($established_at)
    {
        $this->established_at = $established_at;
    }
}
