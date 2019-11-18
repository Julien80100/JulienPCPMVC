<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/entity"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

//var_dump(__DIR__."/entity");die;
// database configuration parameters
$conn = array(
          'driver' => 'pdo_mysql',
          'user' => 'julien',
          'password' => '2018',
          'host' => 'localhost',
          'dbname' => 'julien',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

//
$class = "Controllers\\" . (isset($_GET['c']) ? ucfirst($_GET['c']) . 'Controller' : 'IndexController');
$target = isset($_GET['t']) ? $_GET['t'] : "index";
$getParams = isset($_GET) ? $_GET : null;
$postParams = isset($_POST) ? $_POST : null;
$params = [
    "get"  => $getParams,
    "post" => $postParams,
    "entitymanager" => $entityManager,
    "path" => 'http://195.154.118.169/julien/TP/'
];

if (class_exists($class, true)) {
    $class = new $class();
    if (in_array($target, get_class_methods($class))) {
        call_user_func_array([$class, $target], $params);
    } else {
        call_user_func([$class, "index"]);
    }
} else {
    echo "404 - Error";
}