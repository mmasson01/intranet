<?php

namespace Intra\ModuleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Baremepoint
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Intra\ModuleBundle\Entity\BaremepointRepository")
 */
class Baremepoint
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="Intra\ModuleBundle\Entity\Baremecritere", inversedBy="points")
     */
    private $critere;


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
     * Set number
     *
     * @param integer $number
     * @return Baremepoint
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set critere
     *
     * @param \Intra\ModuleBundle\Entity\Baremecritere $critere
     * @return Baremepoint
     */
    public function setCritere(\Intra\ModuleBundle\Entity\Baremecritere $critere = null)
    {
        $this->critere = $critere;

        return $this;
    }

    /**
     * Get critere
     *
     * @return \Intra\ModuleBundle\Entity\Baremecritere 
     */
    public function getCritere()
    {
        return $this->critere;
    }
}
