<?php

namespace Intra\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reply
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Intra\TicketBundle\Entity\ReplyRepository")
 */
class Reply
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
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @ORM\ManyToOne(targetEntity="Intra\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auteur;

    /**
     * @var integer
     *
     * @ORM\Column(name="auteur_id", type="integer")
     */
    private $auteur_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="ticket_id", type="integer")
     */
    private $ticket_id;

    public function __construct()
    {
        $this->datetime = new \DateTime();
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
     * @return Reply
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
     * Set datetime
     *
     * @param \DateTime $datetime
     * @return Reply
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime 
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set auteur_id
     *
     * @param integer $auteurId
     * @return Reply
     */
    public function setAuteurId($auteurId)
    {
        $this->auteur_id = $auteurId;

        return $this;
    }

    /**
     * Get auteur_id
     *
     * @return integer 
     */
    public function getAuteurId()
    {
        return $this->auteur_id;
    }

    /**
     * Set ticket_id
     *
     * @param integer $ticketId
     * @return Reply
     */
    public function setTicketId($ticketId)
    {
        $this->ticket_id = $ticketId;

        return $this;
    }

    /**
     * Get ticket_id
     *
     * @return integer 
     */
    public function getTicketId()
    {
        return $this->ticket_id;
    }

    /**
     * Set auteur
     *
     * @param \Intra\UserBundle\Entity\User $auteur
     * @return Reply
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
}
