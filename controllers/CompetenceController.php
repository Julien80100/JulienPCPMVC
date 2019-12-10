<?php

namespace Controllers;

use Models\Competences;
use entity\Competence;
use Entity\Request;

class CompetenceController extends Controller
{
    public function index()
    {
        echo "Hello Competence Page!";
    }

      public function list(Request $request)
    {
        $competenceRepository = $request->getEm()->getRepository('Entity\Competence');
        $competences = $competenceRepository->findall();               
      echo $this->twig->render('list.html',
        [
          "competences" => $competences,
          "quantity" => count($competences)          
        ]
      );
    }
}