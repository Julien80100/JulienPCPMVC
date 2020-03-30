<?php

namespace Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

     /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $role;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $IsConnected;
  
    /**
     * @ORM\Column(type="integer")
     */
    private $question;
  
    /**
     * @ORM\Column(type="string")
     */
    private $answer;
  
    /**
     * @ORM\Column(type="integer")
     */
    private $tuteur;
  
  
    public function __toString()
    {
      return $this->username;    
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
     * Set username.
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set role.
     *
     * @param int $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set isConnected.
     *
     * @param bool $isConnected
     *
     * @return User
     */
    public function setIsConnected($isConnected)
    {
        $this->IsConnected = $isConnected;

        return $this;
    }

    /**
     * Get isConnected.
     *
     * @return bool
     */
    public function getIsConnected()
    {
        return $this->IsConnected;
    }
  
     /**
     * Set question.
     *
     * @param int $question
     *
     * @return User
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question.
     *
     * @return int
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set answer.
     *
     * @param string $answer
     *
     * @return User
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer.
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }
     /**
     * Set question.
     *
     * @param int $question
     *
     * @return User
     */
    public function setTuteur($tuteur)
    {
        $this->tuteur = $tuteur;

        return $this;
    }

    /**
     * Get question.
     *
     * @return int
     */
    public function getTuteur()
    {
        return $this->tuteur;
    }
}