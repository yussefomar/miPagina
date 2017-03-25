<?php

namespace Proyecto\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comodin
 *
 * @ORM\Table(name="comodin")
 * @ORM\Entity(repositoryClass="Proyecto\UserBundle\Repository\ComodinRepository")
 */
class Comodin
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="comodin", type="string", length=50)
     */
    private $comodin;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=50)
     */
    private $descripcion;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set comodin
     *
     * @param string $comodin
     * @return Comodin
     */
    public function setComodin($comodin)
    {
        $this->comodin = $comodin;

        return $this;
    }

    /**
     * Get comodin
     *
     * @return string 
     */
    public function getComodin()
    {
        return $this->comodin;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Comodin
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}
