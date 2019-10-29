<?php
use Entity\Tache;
// list_Tache.php
require_once "bootstrap.php";

$tacheRepository = $entityManager->getRepository('Entity\Tache');
$taches = $tacheRepository->findAll();

foreach ($taches as $tache) {
    echo sprintf("-%s\n", $taches->getDescription());
}