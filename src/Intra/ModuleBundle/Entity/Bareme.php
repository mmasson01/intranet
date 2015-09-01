<?php

namespace Intra\ModuleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bareme
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Intra\ModuleBundle\Entity\BaremeRepository")
 */
class Bareme
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
     * @ORM\OneToOne(targetEntity="Intra\ModuleBundle\Entity\Activite", inversedBy="bareme")
     */
    private $activite;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Intra\ModuleBundle\Entity\Baremecritere", mappedBy="bareme", cascade={"persist", "remove"})
     */
    private $criteres;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->criteres = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Bareme
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Add criteres
     *
     * @param \Intra\ModuleBundle\Entity\Baremecritere $criteres
     * @return Bareme
     */
    public function addCritere(\Intra\ModuleBundle\Entity\Baremecritere $criteres)
    {
        $criteres->setBareme($this);
        $this->criteres[] = $criteres;
        return $this;
    }

    /**
     * Remove criteres
     *
     * @param \Intra\ModuleBundle\Entity\Baremecritere $criteres
     */
    public function removeCritere(\Intra\ModuleBundle\Entity\Baremecritere $criteres)
    {
        $this->criteres->removeElement($criteres);
    }

    /**
     * Get criteres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCriteres()
    {
        return $this->criteres;
    }

    /**
     * Set activite
     *
     * @param \Intra\ModuleBundle\Entity\Activite $activite
     * @return Bareme
     */
    public function setActivite(\Intra\ModuleBundle\Entity\Activite $activite = null)
    {
        $this->activite = $activite;

        return $this;
    }

    /**
     * Get activite
     *
     * @return \Intra\ModuleBundle\Entity\Activite 
     */
    public function getActivite()
    {
        return $this->activite;
    }
}
