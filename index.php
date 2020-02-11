<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Entity\Request;
use Entity\User;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations

/**
 * Démarrage de la session
 */
session_start();

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/entity"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

$conn = array(
  
          'driver' => 'pdo_mysql',
          'user' => 'julien',
          'password' => '2018',
          'host' => 'localhost',
          'dbname' => 'julien_projet_pcp',
  
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

$getParams = isset($_GET) ? $_GET : null;
$postParams = isset($_POST) ? $_POST : null;

$request = new Request();
$request->setEm($entityManager);
$request->setPost($postParams);
$request->setGet($getParams);

if (isset($_SESSION['id'])) {
  
  $user = $entityManager->getRepository(User::class)->find($_SESSION['id']);
  $request->setUser($user);
  
}

$target = isset($_GET['t']) ? $_GET['t'] : "connected";
$class = "Controllers\\" . (isset($_GET['c']) ? ucfirst($_GET['c']) . 'Controller' : 'UserController');

if ( null !== $request->getUser() ) {
  
  $target = isset($_GET['t']) ? $_GET['t'] : "index";
  
} else {
  
  if ($target !== "connected"){
    
    if ( "registration" == $_GET['t'] || "registered" == $_GET['t'] || "lostpassword" == $_GET['t'] || "lostusername" == $_GET['t'] ){

        $target = isset($_GET['t']) ? $_GET['t'] : "index";
      
    } else {
      
       $target = isset($_GET['t']) ? $_GET['t'] : "connected";
      
    }
 
  } else {
      
      $target = isset($_GET['t']) ? $_GET['t'] : "connected";
  }
  
}


$params = [
    "request" => $request,
];
  if (class_exists($class, true)) {
    $user = $request->getUser();

      
      $class = new $class();
      if (in_array($target, get_class_methods($class))) {
          call_user_func_array([$class, $target], $params);
      } else {
          call_user_func([$class, "index"]);
      }
  }
