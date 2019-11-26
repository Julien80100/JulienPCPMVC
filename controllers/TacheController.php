<?php
namespace Controllers;
use Models\Taches;
use Entity\Tache;

class TacheController extends Controller
{
    public function index()
    {
      echo('tache page');
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
  
    public function new($get, $post, $em, $path)
      {
        $competences = $em->getRepository("Entity\Competence")->findAll();
        echo $this->twig->render('form.html',
          [
            "competences" => $competences
          ]
        );
      }
  
    public function created($get, $post, $em, $path)
      {

      $tache = new Tache;
      $tache->setDescription($post['Description']);
      $date = new \DateTime($post['Date']);
      $tache->setDate($date);
      $em->persist($tache);
      $em->flush(); 
      $competences=$post['competences'];
      $competenceTab=[];
      foreach ($competences as $competenceId) {
          $competence = $em->getRepository("Entity\Competence")->find($competenceId);
          if ($competence) {
            $competenceTab[]=$competence;
          }
      }
      $tache->addCompetences($competenceTab);
      $em->persist($tache);
      $em->flush(); 
        echo $this->twig->render('created.html',
          [
            "tache" => $tache
          ]
        );
      }
  
  public function edit($get, $post, $em, $path)
  {
    $tache = $em->getRepository("Entity\Tache")->findOneBy(["id" => $get["id"]]);
    $competences = $em->getRepository("Entity\Competence")->findAll();
    echo $this->twig->render('update.html',
      [
        "tache" => $tache,
        "competences" => $competences
      ]
    ); 
  }
  
  public function updated($get, $post, $em, $path)
  {
    
    $tache = $em->getRepository("Entity\Tache")->find($get["id"]); 
    $tache->removeCompetences();
    $em->persist($tache);
    $em->flush();
    
    $tache->setDescription($post['Description']);
    $date = new \DateTime($post['Date']);
    $tache->setDate($date);
    
    
    
    $competences=$post['competences'];
    $competenceTab=[];
    
    foreach ($competences as $competenceId) {
        $competence = $em->getRepository("Entity\Competence")->find($competenceId);
        if ($competence) {
          $competenceTab[]=$competence;
        }
    }
    $tache->addCompetences($competenceTab);
    $em->persist($tache);
    $em->flush(); 
    echo $this->twig->render('updated.html',
      [
        "tache" => $tache
      ]
    );
  }
}