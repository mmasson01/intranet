<?php

namespace Intra\ModuleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Module
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Intra\ModuleBundle\Entity\ModuleRepository")
 */
class Module
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Intra\ModuleBundle\Entity\Activite", mappedBy="module", cascade={"persist", "remove"})
     */
    private $activites;

    /**
     * @ORM\OneToOne(targetEntity="Intra\ForumBundle\Entity\Categorie", cascade={"persist", "remove"})
     */
    private $categorie;

    /**
     * @ORM\ManyToMany(targetEntity="Intra\UserBundle\Entity\User")
     */
    private $inscrit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut_inscription", type="datetime")
     */
    private $dateDebutInscription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_inscription", type="datetime")
     */
    private $dateFinInscription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut_module", type="datetime")
     */
    private $dateDebutModule;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_module", type="datetime")
     */
    private $dateFinModule;

    /**
     * @var integer
     *
     * @ORM\Column(name="valeure", type="integer")
     */
    private $valeure;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbplaces", type="integer")
     */
    private $nbPlaces;


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
     * @return Module
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
     * Set description
     *
     * @param string $description
     * @return Module
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
     * Set valeure
     *
     * @param integer $valeure
     * @return Module
     */
    public function setValeure($valeure)
    {
        $this->valeure = $valeure;

        return $this;
    }

    /**
     * Get valeure
     *
     * @return integer 
     */
    public function getValeure()
    {
        return $this->valeure;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activites = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add activites
     *
     * @param \Intra\ModuleBundle\Entity\Activite $activites
     * @return Module
     */
    public function addActivite(\Intra\ModuleBundle\Entity\Activite $activites)
    {
        $this->activites[] = $activites;

        return $this;
    }

    /**
     * Remove activites
     *
     * @param \Intra\ModuleBundle\Entity\Activite $activites
     */
    public function removeActivite(\Intra\ModuleBundle\Entity\Activite $activites)
    {
        $this->activites->removeElement($activites);
    }

    /**
     * Get activites
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActivites()
    {
        return $this->activites;
    }

    /**
     * Set dateDebutInscription
     *
     * @param \DateTime $dateDebutInscription
     * @return Module
     */
    public function setDateDebutInscription($dateDebutInscription)
    {
        $this->dateDebutInscription = $dateDebutInscription;

        return $this;
    }

    /**
     * Get dateDebutInscription
     *
     * @return \DateTime 
     */
    public function getDateDebutInscription()
    {
        return $this->dateDebutInscription;
    }

    /**
     * Set dateFinInscription
     *
     * @param \DateTime $dateFinInscription
     * @return Module
     */
    public function setDateFinInscription($dateFinInscription)
    {
        $this->dateFinInscription = $dateFinInscription;

        return $this;
    }

    /**
     * Get dateFinInscription
     *
     * @return \DateTime 
     */
    public function getDateFinInscription()
    {
        return $this->dateFinInscription;
    }

    /**
     * Set dateDebutModule
     *
     * @param \DateTime $dateDebutModule
     * @return Module
     */
    public function setDateDebutModule($dateDebutModule)
    {
        $this->dateDebutModule = $dateDebutModule;

        return $this;
    }

    /**
     * Get dateDebutModule
     *
     * @return \DateTime 
     */
    public function getDateDebutModule()
    {
        return $this->dateDebutModule;
    }

    /**
     * Set dateFinModule
     *
     * @param \DateTime $dateFinModule
     * @return Module
     */
    public function setDateFinModule($dateFinModule)
    {
        $this->dateFinModule = $dateFinModule;

        return $this;
    }

    /**
     * Get dateFinModule
     *
     * @return \DateTime 
     */
    public function getDateFinModule()
    {
        return $this->dateFinModule;
    }

    /**
     * Set categorie
     *
     * @param \Intra\ForumBundle\Entity\Categorie $categorie
     * @return Module
     */
    public function setCategorie(\Intra\ForumBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Intra\ForumBundle\Entity\Categorie 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Add inscrit
     *
     * @param \Intra\UserBundle\Entity\User $inscrit
     * @return Module
     */
    public function addInscrit(\Intra\UserBundle\Entity\User $inscrit)
    {
        $this->inscrit[] = $inscrit;

        return $this;
    }

    /**
     * Remove inscrit
     *
     * @param \Intra\UserBundle\Entity\User $inscrit
     */
    public function removeInscrit(\Intra\UserBundle\Entity\User $inscrit)
    {
        $this->inscrit->removeElement($inscrit);
    }

    /**
     * Get inscrit
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInscrit()
    {
        return $this->inscrit;
    }

    /**
     * Set nbPlaces
     *
     * @param integer $nbPlaces
     * @return Module
     */
    public function setNbPlaces($nbPlaces)
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
    }

    /**
     * Get nbPlaces
     *
     * @return integer 
     */
    public function getNbPlaces()
    {
        return $this->nbPlaces;
    }
}
