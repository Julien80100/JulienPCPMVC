<?php
use Entity\Competence;
// list_Competence.php
require_once "bootstrap.php";

$competenceRepository = $entityManager->getRepository('Entity\Competence');
$competences = $competenceRepository->findAll();

foreach ($competences as $competence) {
    echo sprintf("-%s\n", $competence->getTitle());
}