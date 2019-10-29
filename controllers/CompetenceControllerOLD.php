<?php

namespace Controllers;

use Models\Competences;

class CompetenceController extends Controller
{
    public function index()
    {
        echo "Hello Competence Page!";
    }

    public function create($params)
    {
      if (!isset($params['Label'])) {
        $label = "Example";
      } else {
        $label = $params['Label'];
      }
      $competenceMapper = spot()->mapper('Models\Competences');
      $competenceMapper->migrate();
      $myNewCompetence = $competenceMapper->create([
        'Label'        => $label,
        'type'         => 'default',
        'ActivityID'   => '0',
        'CompetenceID' => '0',
        'epreuve'      => 'U0',
      ]);
      echo "A new competences has been created: " . $myNewCompetence->label;
    }

      public function list()
    {
      $competenceMapper = spot()->mapper('Models\Competences');
      $competenceMapper->migrate();
      $competenceList = $competenceMapper->all();
        
      echo $this->twig->render('list.html',
        [
          "competences" => $competenceList,
          "quantity" => count($competenceList)
        ]
      );
    }
}