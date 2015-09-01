<?php

namespace Intra\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Thread
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Intra\ForumBundle\Entity\ThreadRepository")
 */
class Thread
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
     * @ORM\Column(name="sujet", type="text")
     */
    private $sujet;

    /**
     * @ORM\ManyToOne(targetEntity="Intra\UserBundle\Entity\User")
     */
    private $auteur;

    /**
     * @ORM\ManyToOne(targetEntity="Intra\ForumBundle\Entity\Categorie")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity="Intra\ForumBundle\Entity\Commentaire", mappedBy="thread", cascade={"persist", "remove"})
     */
    protected $commentaires;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_activite", type="datetime")
     */
    private $dateActivite;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->dateActivite = new \DateTime();
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
     * Set sujet
     *
     * @param string $sujet
     * @return Thread
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Get sujet
     *
     * @return string 
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set auteur
     *
     * @param \Intra\UserBundle\Entity\User $auteur
     * @return Thread
     */
    public function setAuteur(\Intra\UserBundle\Entity\User $auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return \Intra\UserBundle\Entity\User
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Thread
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateActivite
     *
     * @param \DateTime $dateActivite
     * @return Thread
     */
    public function setDateActivite($dateActivite)
    {
        $this->dateActivite = $dateActivite;

        return $this;
    }

    /**
     * Get dateActivite
     *
     * @return \DateTime 
     */
    public function getDateActivite()
    {
        return $this->dateActivite;
    }

    /**
     * Set categorie
     *
     * @param \Intra\ForumBundle\Entity\Categorie $categorie
     * @return Thread
     */
    public function setCategorie(\Intra\ForumBundle\Entity\Categorie $categorie)
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
     * Add commentaire
     *
     * @param \Intra\ForumBundle\Entity\Commentaire $commentaire
     * @return Thread
     */
    public function addCommentaire(\Intra\ForumBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires[] = $commentaires;

        return $this;
    }

    /**
     * Remove commentaire
     *
     * @param \Intra\ForumBundle\Entity\Commentaire $commentaire
     */
    public function removeCommentaire(\Intra\ForumBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires->removeElement($commentaire);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }
}
