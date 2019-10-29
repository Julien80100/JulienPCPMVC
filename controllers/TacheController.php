<?php

namespace Controllers;

use Models\Taches;
use entity\Tache;

class TacheController extends Controller
{
    public function index()
    {
        echo "Hello Tache Page!";
    }

      public function list($get, $post, $em)
    {
        $tacheRepository = $em->getRepository('Entity\Tache');
        $taches = $tacheRepository->findall();               
//         foreach($taches as $tache) {
//           echo $tache->getId();
//           echo $tache->getDescription();
//         }
      echo $this->twig->render('list.html',
        [
          "taches" => $taches,
          "quantity" => count($taches)
        ]
      );
    }
}