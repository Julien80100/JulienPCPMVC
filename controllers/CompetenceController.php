<?php

namespace Controllers;

use Models\Competences;
use Entity\Competence;
use Entity\Tache;
use Entity\Request;

class CompetenceController extends Controller
{
    public function index()
    {
        header('Location: ?c=user&t=connected');
    }

    public function list(Request $request)
    {
        $user = $request->getUser();
        $competenceRepository = $request->getEm()->getRepository('Entity\Competence');
        $competences = $competenceRepository->findall();
        $taches = $request->getEm()->getRepository('Entity\Competence')->findAll();
      echo $this->twig->render('list.html',
        [
          "user" => $user,
          "competences" => $competences,
          "quantity" => count($competences), 
        ]
      );
    }
  
   public function create($request)
   {
    $user = $request->getUser();
    echo $this->twig->render('create.html',
      [
        "user" => $user,
      ]
    ); 
   }
  
    public function created(Request $request)
    {
        $post = $request->getPost();
        $em = $request->getEm();
        $user = $request->getUser();
        $competence = new Competence;
        $competence->setTitle($post['titre']);
        $competence->setActivity($post['activity']);
        $competence->setEpreuve($post['epreuve']);
        $competence->setType($post['type']);
        $em->persist($competence);
        $em->flush(); 
        $this->create($request);
    }
}