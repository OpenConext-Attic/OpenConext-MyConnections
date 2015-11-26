<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="orcid",
 *     indexes={@ORM\Index(name="value_idx", columns={"value"})}
 * )
 * @ExclusionPolicy("all")
 */
class Orcid
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     name="id",
     *     nullable=false
     * )
     * @Expose()
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     name="value",
     *     nullable=false
     * )
     * @Expose()
     */
    protected $value;

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
