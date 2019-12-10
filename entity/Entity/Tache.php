<?php

namespace Entity;

/**
 * Tache
 */
class Tache
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Entity\User
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $competences;

    
