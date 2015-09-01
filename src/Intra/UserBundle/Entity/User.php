<?php
// src/Intra/UserBundle/Entity/User.php

namespace Intra\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use FR3D\LdapBundle\Model\LdapUserInterface as LdapUserInterface;
use Doctrine\ORM\Mapping as ORM;
use Intra\TicketBundle\Entity\Ticket as Ticket;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Intra\UserBundle\Entity\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser implements LdapUserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    protected $dn;

    protected $login;

    protected $mail;

    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Intra\TicketBundle\Entity\Ticket", mappedBy="Auteur", cascade={"persist", "remove"})
     */
    protected $tickets;

    /**
     * @ORM\OneToMany(targetEntity="Intra\TicketBundle\Entity\Ticket", mappedBy="Admin")
     */
    protected $tickets_administres;  

    public function __construct()
    {
        parent::__construct();
        $this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setDn($dn) {
        $this->dn = $dn;
    }
    public function getDn() {
        return $this->dn;
    }

    public function setLogin($login) {
        $this->login = $login;
    }
    public function getLogin() {
        return $this->login;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }
    public function getMail() {
        return $this->mail;
    }

    public function setName($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
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
     * Remove tickets
     *
     * @param \Intra\TicketBundle\Entity\Ticket $tickets
     */
    public function removeTicket(\Intra\TicketBundle\Entity\Ticket $tickets)
    {
        $this->tickets->removeElement($tickets);
    }

    /**
     * Add tickets_administres
     *
     * @param \Intra\TicketBundle\Entity\Ticket $ticketsAdministres
     * @return User
     */
    public function addTicketsAdministre(\Intra\TicketBundle\Entity\Ticket $ticketsAdministres)
    {
        $this->tickets_administres[] = $ticketsAdministres;

        return $this;
    }

    /**
     * Remove tickets_administres
     *
     * @param \Intra\TicketBundle\Entity\Ticket $ticketsAdministres
     */
    public function removeTicketsAdministre(\Intra\TicketBundle\Entity\Ticket $ticketsAdministres)
    {
        $this->tickets_administres->removeElement($ticketsAdministres);
    }

    /**
     * Get tickets_administres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTicketsAdministres()
    {
        return $this->tickets_administres;
    }

    /**
     * Add tickets
     *
     * @param \Intra\TicketBundle\Entity\Ticket $tickets
     * @return User
     */
    public function addTicket(\Intra\TicketBundle\Entity\Ticket $tickets)
    {
        $this->tickets[] = $tickets;

        return $this;
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTickets()
    {
        return $this->tickets;
    }
   
}
