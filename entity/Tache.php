<?php

namespace Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tache")
 */
class Tache
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /** 
     * @ORM\Column(type="date") 
     */
    protected $date;
    /** 
     * @ORM\Column(type="text") 
     */
    protected $description;
    /**
    * @ORM\ManyToOne(targetEntity="User")
    */
    protected $user;
  
    /**
     * @ORM\ManyToMany(targetEntity="Competence", inversedBy="taches")
     */
    protected $competences;

    public function addCompetences($competences)
    {
        foreach ($competences as $competence) {
          $this->addCompetence($competence);
        }
        return $this;
    }
  
  //******************************************************************************
 
  /**
     * Constructor
     */
    public function __construct()
    {
        $this->competences = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Tache
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Tache
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set user.
     *
     * @param \Entity\User|null $user
     *
     * @return Tache
     */
    public function setUser(\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add competence.
     *
     * @param \Entity\Competence $competence
     *
     * @return Tache
     */
    public function addCompetence(\Entity\Competence $competence)
    {
        $this->competences[] = $competence;

        return $this;
    }

    /**
     * Remove competence.
     *
     * @param \Entity\Competence $competence
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCompetence(\Entity\Competence $competence)
    {
        return $this->competences->removeElement($competence);
    }

    /**
     * Get competences.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetences()
    {
        return $this->competences;
    }
}
}
