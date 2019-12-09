<?php
namespace Controllers;
use Models\Taches;
use Entity\Tache;
use Entity\Request;

class TacheController extends Controller
{
    public function index()
    {
      echo('tache page');
    }
  
    public function list(Request $request)
    {
      $tacheRepository = $request->getEm()->getRepository('Entity\Tache');
      $taches = $tacheRepository->findAll();               
      echo $this->twig->render('list.html',
        [
        "taches" => $taches,
        "quantity" => count($taches)
        ]
      );
    }
  
    public function new(Request $request)
      {
        $competences = $em->getRepository("Entity\Competence")->findAll();
        echo $this->twig->render('form.html',
          [
            "competences" => $competences
          ]
        );
      }
  
    public function created(Request $request)
    {
      
        $em = $request->getEm();
    
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
  
  public function edit(Request $request)
  {
    
    $em = $request->getEm();
    
    $tache = $em->getRepository("Entity\Tache")->findOneBy(["id" => $get["id"]]);
    $competences = $em->getRepository("Entity\Competence")->findAll();
    echo $this->twig->render('update.html',
      [
        "tache" => $tache,
        "competences" => $competences
      ]
    );
    
  }
  
  public function updated(Request $request)
  {
    
    $tache = $request->getEm->getRepository("Entity\Tache")->find($request->getGet["id"]); 
    $tache->removeCompetences();
    $request->getEm->persist($tache);
    $request->getEm->flush();
    
    $tache->setDescription($request->getPost['Description']);
    $date = new \DateTime($request->getPost['Date']);
    $tache->setDate($date);
    
    $competences=$request->getPost['competences'];
    $competenceTab=[];
    
    foreach ($competences as $competenceId) {
        $competence = $request->getEm->getRepository("Entity\Competence")->find($competenceId);
        if ($competence) {
          $competenceTab[]=$competence;
        }
    }
    $tache->addCompetences($competenceTab);
    $request->getEm->persist($tache);
    $request->getEm->flush(); 
    echo $this->twig->render('updated.html',
      [
        "tache" => $tache
      ]
    );
  }
  
  public function remove(Request $request)
  {
    $tache = $request->getEm->getRepository("Entity\Tache")->findOneBy(["id" => $request->getGet["id"]]);
    $competences = $request->getEm->getRepository("Entity\Competence")->findAll();
    echo $this->twig->render('remove.html',
      [
        "tache" => $tache,
        "competences" => $competences
      ]
    ); 
  }
  
  public function deleted(Request $request)
  {
    $tache = $request->getEm->getRepository("Entity\Tache")->find($request->getGet["id"]); 
    $request->getEm->remove($tache);
//     $em->persist($tache);
    $request->getEm->flush();
    
    $this->list($request);
//     echo $this->twig->render('deleted.html',[]); 
  }
}