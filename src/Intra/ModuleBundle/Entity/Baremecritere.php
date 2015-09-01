<?php

namespace Intra\ModuleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Baremecritere
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Intra\ModuleBundle\Entity\BaremecritereRepository")
 */
class Baremecritere
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Intra\ModuleBundle\Entity\Bareme", inversedBy="criteres")
     */
    private $bareme;

    /**
     * @ORM\OneToMany(targetEntity="Intra\ModuleBundle\Entity\Baremepoint", mappedBy="critere", cascade={"persist", "remove"})
     */
    private $points;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->points = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set titre
     *
     * @param string $titre
     * @return Baremecritere
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Baremecritere
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set bareme
     *
     * @param \Intra\ModuleBundle\Entity\Bareme $bareme
     * @return Baremecritere
     */
    public function setBareme(\Intra\ModuleBundle\Entity\Bareme $bareme = null)
    {
        $this->bareme = $bareme;

        return $this;
    }

    /**
     * Get bareme
     *
     * @return \Intra\ModuleBundle\Entity\Bareme 
     */
    public function getBareme()
    {
        return $this->bareme;
    }

    /**
     * Add points
     *
     * @param \Intra\ModuleBundle\Entity\Baremepoint $points
     * @return Baremecritere
     */
    public function addPoint(\Intra\ModuleBundle\Entity\Baremepoint $points)
    {
        $points->setCritere($this);
        $this->points[] = $points;

        return $this;
    }

    /**
     * Remove points
     *
     * @param \Intra\ModuleBundle\Entity\Baremepoint $points
     */
    public function removePoint(\Intra\ModuleBundle\Entity\Baremepoint $points)
    {
        $this->points->removeElement($points);
    }

    /**
     * Get points
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPoints()
    {
        return $this->points;
    }
}
