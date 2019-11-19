<?php

namespace Controllers;

use Models\Competences;
use entity\Competence;

class CompetenceController extends Controller
{
    public function index()
    {
        echo "Hello Competence Page!";
    }

      public function list($get, $post, $em)
    {
        $competenceRepository = $em->getRepository('Entity\Competence');
        $competences = $competenceRepository->findall();               
      echo $this->twig->render('list.html',
        [
          "competences" => $competences,
          "quantity" => count($competences)          
        ]
      );
    }
}