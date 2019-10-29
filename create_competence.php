<?php
use Entity\Competence;
// create_competence.php <Julien>
require_once "bootstrap.php";

$newCompetenceTitle = $argv[1];

$competence = new Competence();
$competence->setTitle($newCompetenceTitle);

$entityManager->persist($competence);
$entityManager->flush();

echo "Created Competence with ID " . $competence->getId() . "\n";
