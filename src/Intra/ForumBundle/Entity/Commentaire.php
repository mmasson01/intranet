<?php

namespace Intra\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Intra\ForumBundle\Entity\CommentaireRepository")
 */
class Commentaire
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
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity="Intra\UserBundle\Entity\User")
     */
    private $auteur;

    /**
     * @ORM\ManyToOne(targetEntity="Intra\ForumBundle\Entity\Thread", inversedBy="commentaires")
     */
    private $thread;

    /**
     * @ORM\OneToMany(targetEntity="Intra\ForumBundle\Entity\Commentaire", mappedBy="sur_commentaire", cascade={"persist", "remove"})
     */
    protected $commentaires;

    /**
     * @ORM\ManyToOne(targetEntity="Intra\ForumBundle\Entity\Commentaire", inversedBy="commentaires")
     */
    protected $sur_commentaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
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
     * Set contenu
     *
     * @param string $contenu
     * @return Commentaire
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Commentaire
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
     * Set auteur
     *
     * @param \Intra\UserBundle\Entity\User $auteur
     * @return Commentaire
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
     * Set thread
     *
     * @param \Intra\ForumBundle\Entity\Thread $thread
     * @return Commentaire
     */
    public function setThread(\Intra\ForumBundle\Entity\Thread $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \Intra\ForumBundle\Entity\Thread 
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Add commentaires
     *
     * @param \Intra\ForumBundle\Entity\Commentaire $commentaires
     * @return Commentaire
     */
    public function addCommentaire(\Intra\ForumBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires[] = $commentaires;

        return $this;
    }

    /**
     * Remove commentaires
     *
     * @param \Intra\ForumBundle\Entity\Commentaire $commentaires
     */
    public function removeCommentaire(\Intra\ForumBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires->removeElement($commentaires);
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

    /**
     * Set sur_commentaire
     *
     * @param \Intra\ForumBundle\Entity\Commentaire $surCommentaire
     * @return Commentaire
     */
    public function setSurCommentaire(\Intra\ForumBundle\Entity\Commentaire $surCommentaire = null)
    {
        $this->sur_commentaire = $surCommentaire;

        return $this;
    }

    /**
     * Get sur_commentaire
     *
     * @return \Intra\ForumBundle\Entity\Commentaire 
     */
    public function getSurCommentaire()
    {
        return $this->sur_commentaire;
    }
}
