<?php
use Entity\Tache;
// create_tache.php <Julien>
require_once "bootstrap.php";

$newTacheTitle = $argv[1];

$tache = new Tache();
$tache->setDescription($newTacheDescription);

$entityManager->persist($tache);
$entityManager->flush();

echo "Created Tache with ID " . $tache->getId() . "\n";
