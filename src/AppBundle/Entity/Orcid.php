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
     *     name="key",
     *     nullable=false
     * )
     * @Expose()
     */
    protected $key;

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
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }
}
