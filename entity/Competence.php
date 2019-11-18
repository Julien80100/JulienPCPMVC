<?php

namespace Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="competence")
 */
class Competence
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /** 
     * @ORM\Column(type="string") 
     */
    protected $type;
    /** 
     * @ORM\Column(type="string") 
     */
    protected $title;
  


    // .. (other code)

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
     * Set date
     *
     * @param date $type
     *
     * @return Table
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Competence
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set competenceID.
     *
     * @param string $competenceID
     *
     * @return Competence
     */
    public function setCompetenceID($competenceID)
    {
        $this->competenceID = $competenceID;

        return $this;
    }

    /**
     * Get competenceID.
     *
     * @return string
     */
    public function getCompetenceID()
    {
        return $this->competenceID;
    }

    /**
     * Set activityID.
     *
     * @param string $activityID
     *
     * @return Competence
     */
    public function setActivityID($activityID)
    {
        $this->activityID = $activityID;

        return $this;
    }

    /**
     * Get activityID.
     *
     * @return string
     */
    public function getActivityID()
    {
        return $this->activityID;
    }

    /**
     * Set epreuve.
     *
     * @param string $epreuve
     *
     * @return Competence
     */
    public function setEpreuve($epreuve)
    {
        $this->epreuve = $epreuve;

        return $this;
    }

    /**
     * Get epreuve.
     *
     * @return string
     */
    public function getEpreuve()
    {
        return $this->epreuve;
    }
}
