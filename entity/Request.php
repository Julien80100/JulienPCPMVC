<?php

namespace Entity;

use Entity\User;

class Request
{
  
  private $em;
  
  private $post;
  
  private $get;
  
  private $user;
  
  /*public function __construct($get = null, $post = null, $em = null, User $user = null) {
    
    $this->get=$get;
    $this->post=$post;
    $this->em=$em;
    $this->setUser($user);
    
  }*/
  
  public function setEm($em)
  {
      $this->em = $em;
  }
  
  public function getEm()
  {
    return $this->em;
  }
  
  public function setPost($post)
  {
    $this->post = $post;
  }
  
  public function getPost(){
    return $this->post;
  }
  
  public function setGet($get)
  {
    $this->get = $get;
  }
  
  public function getGet()
  {
    return $this->get;
  }
  
  public function getUser()
  {
    return $this->user;
  }
  
  public function setUser(User $user)
  {
    $this->user=$user;
  }
  
}