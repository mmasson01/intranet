<?php

namespace Intra\CorrectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Correction
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Intra\CorrectionBundle\Entity\CorrectionRepository")
 */
class Correction
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
     * @ORM\Column(name="Note", type="integer")
     */
    private $note;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enregistree", type="boolean")
     */
    private $enregistree;

    /**
     * @ORM\ManytoOne(targetEntity="Intra\ModuleBundle\Entity\Activite")
     */
    private $activite;

    /**
     * @ORM\ManyToOne(targetEntity="Intra\UserBundle\Entity\User")
     */
    private $correcteur;

    /**
     * @ORM\ManyToOne(targetEntity="Intra\UserBundle\Entity\User")
     */
    private $corrige;

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
     * Set note
     *
     * @param integer $note
     * @return Correction
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set activite
     *
     * @param \Intra\ModuleBundle\Entity\Activite $activite
     * @return Correction
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

    /**
     * Set correcteur
     *
     * @param \Intra\UserBundle\Entity\User $correcteur
     * @return Correction
     */
    public function setCorrecteur(\Intra\UserBundle\Entity\User $correcteur = null)
    {
        $this->correcteur = $correcteur;

        return $this;
    }

    /**
     * Get correcteur
     *
     * @return \Intra\UserBundle\Entity\User 
     */
    public function getCorrecteur()
    {
        return $this->correcteur;
    }

    /**
     * Set enregistree
     *
     * @param boolean $enregistree
     * @return Correction
     */
    public function setEnregistree($enregistree)
    {
        $this->enregistree = $enregistree;

        return $this;
    }

    /**
     * Get enregistree
     *
     * @return boolean 
     */
    public function getEnregistree()
    {
        return $this->enregistree;
    }

    /**
     * Set corrige
     *
     * @param \Intra\UserBundle\Entity\User $corrige
     * @return Correction
     */
    public function setCorrige(\Intra\UserBundle\Entity\User $corrige = null)
    {
        $this->corrige = $corrige;

        return $this;
    }

    /**
     * Get corrige
     *
     * @return \Intra\UserBundle\Entity\User 
     */
    public function getCorrige()
    {
        return $this->corrige;
    }
}
