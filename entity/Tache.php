<?php

namespace Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="taches")
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
     * @param date $date
     *
     * @return Table
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }
  
    /**
     * Set description
     *
     * @param description $description
     *
     * @return Table
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

}
