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
     * @ORM\Column(type="string") 
     */
    protected $libelle;
    /**
    * @ORM\ManyToOne(targetEntity="User")
    */
    protected $user;
    /**
     * @ORM\column(name="isveille", type="boolean", options={"default":"0"})
     */
    protected $isveille;
  
    /**
     * @ORM\ManyToMany(targetEntity="Competence", inversedBy="taches")
     */
    protected $competences;

    /**
     * @ORM\column(name="validebytuteur", type="boolean", options={"default":"0"})
     */
    protected $validebytuteur;
  
    public function addCompetences($competences)
    {
        foreach ($competences as $competence) {
          $this->addCompetence($competence);
        }
        return $this;
    }
  
    public function removeCompetences($competences)
    {
        foreach ($competences as $competence) {
          $this->removeCompetence($competence);
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
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return Tache
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle.
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
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

    
      /**
     * Set isveille.
     *
     * @param boolean $isveille
     *
     * @return Tache
     */
    public function setIsveille($isveille)
    {
        $this->isveille = $isveille;

        return $this;
    }

    /**
     * Get isveille.
     *
     * @return boolean
     */
    public function getIsveille()
    {
        return $this->isveille;
    }

    
      /**
     * Set validebytuteur.
     *
     * @param boolean $validebytuteur
     *
     * @return Tache
     */
    public function setValidebytuteur($validebytuteur)
    {
        $this->validebytuteur = $validebytuteur;

        return $this;
    }

    /**
     * Get validebytuteur.
     *
     * @return boolean
     */
    public function getValidebytuteur()
    {
        return $this->validebytuteur;
    }

}  