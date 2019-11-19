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
    /** 
     * @ORM\Column(type="string") 
     */
    protected $declinaison;
    /** 
     * @ORM\Column(type="string") 
     */
    protected $activity;
    /** 
     * @ORM\Column(type="string") 
     */
    protected $epreuve;


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
     * Set type.
     *
     * @param string $type
     *
     * @return Competence
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
     * Set declinaison.
     *
     * @param string $declinaison
     *
     * @return Competence
     */
    public function setDeclinaison($declinaison)
    {
        $this->declinaison = $declinaison;

        return $this;
    }

    /**
     * Get declinaison.
     *
     * @return string
     */
    public function getDeclinaison()
    {
        return $this->declinaison;
    }

    /**
     * Set activity.
     *
     * @param string $activity
     *
     * @return Competence
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity.
     *
     * @return string
     */
    public function getActivity()
    {
        return $this->activity;
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
