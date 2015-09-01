<?php

namespace Intra\ModuleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activite
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Intra\ModuleBundle\Entity\ActiviteRepository")
 */
class Activite
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
     * @ORM\ManyToOne(targetEntity="Intra\ModuleBundle\Entity\Module", inversedBy="activites")
     */
    private $module;

    /**
     * @ORM\OneToOne(targetEntity="Intra\ForumBundle\Entity\Categorie", cascade={"persist", "remove"})
     */
    private $categorie;

    /**
     * @ORM\OneToOne(targetEntity="Intra\ModuleBundle\Entity\Bareme", mappedBy="activite", cascade={"persist", "remove"})
     */
    private $bareme;

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
     * @ORM\Column(name="date_debut_activite", type="datetime")
     */
    private $dateDebutActivite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_activite", type="datetime")
     */
    private $dateFinActivite;

    /**
     * @var integer
     *
     * @ORM\Column(name="taille_groupe", type="integer")
     */
    private $tailleGroupe;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_peers", type="integer")
     */
    private $nbPeers;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

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
     * @return Activite
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
     * @return Activite
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
     * Set tailleGroupe
     *
     * @param integer $tailleGroupe
     * @return Activite
     */
    public function setTailleGroupe($tailleGroupe)
    {
        $this->tailleGroupe = $tailleGroupe;

        return $this;
    }

    /**
     * Get tailleGroupe
     *
     * @return integer 
     */
    public function getTailleGroupe()
    {
        return $this->tailleGroupe;
    }

    /**
     * Set nbPeers
     *
     * @param integer $nbPeers
     * @return Activite
     */
    public function setNbPeers($nbPeers)
    {
        $this->nbPeers = $nbPeers;

        return $this;
    }

    /**
     * Get nbPeers
     *
     * @return integer 
     */
    public function getNbPeers()
    {
        return $this->nbPeers;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Activite
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
    

    /**
     * Set module
     *
     * @param \Intra\ModuleBundle\Entity\Module $module
     * @return Activite
     */
    public function setModule(\Intra\ModuleBundle\Entity\Module $module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \Intra\ModuleBundle\Entity\Module 
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set dateDebutInscription
     *
     * @param \DateTime $dateDebutInscription
     * @return Activite
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
     * @return Activite
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
     * Set dateDebutActivite
     *
     * @param \DateTime $dateDebutActivite
     * @return Activite
     */
    public function setDateDebutActivite($dateDebutActivite)
    {
        $this->dateDebutActivite = $dateDebutActivite;

        return $this;
    }

    /**
     * Get dateDebutActivite
     *
     * @return \DateTime 
     */
    public function getDateDebutActivite()
    {
        return $this->dateDebutActivite;
    }

    /**
     * Set dateFinActivite
     *
     * @param \DateTime $dateFinActivite
     * @return Activite
     */
    public function setDateFinActivite($dateFinActivite)
    {
        $this->dateFinActivite = $dateFinActivite;

        return $this;
    }

    /**
     * Get dateFinActivite
     *
     * @return \DateTime 
     */
    public function getDateFinActivite()
    {
        return $this->dateFinActivite;
    }

    /**
     * Set categorie
     *
     * @param \Intra\ForumBundle\Entity\Categorie $categorie
     * @return Activite
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
     * Constructor
     */
    public function __construct()
    {
        $this->inscrit = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add inscrit
     *
     * @param \Intra\UserBundle\Entity\User $inscrit
     * @return Activite
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
     * Set bareme
     *
     * @param \Intra\ModuleBundle\Entity\Bareme $bareme
     * @return Activite
     */
    public function setBareme(\Intra\ModuleBundle\Entity\Bareme $bareme = null)
    {
        $bareme->setActivite($this);
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
     * Set nbPlaces
     *
     * @param integer $nbPlaces
     * @return Activite
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
