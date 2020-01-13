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
      $user = $request->getUser();
      if (NULL ==! $user && $user->getIsConnected() == 1){ 


        $tacheRepository = $request->getEm()->getRepository('Entity\Tache');
        $taches = $tacheRepository->findAll();       
        
  
        echo $this->twig->render('listglobal.html',
          [
          "taches" => $taches,
          "quantity" => count($taches),
          "user"  =>  $user,
          ]
        );
      } else {
        header('Location: ?c=user&t=connected');
      }
    }
  
    public function new(Request $request)
      {
        $em = $request->getEm();
      $user = $request->getUser();
      
      if (NULL !== $user && $user->getRole() !== 1) { 
        $competences = $em->getRepository("Entity\Competence")->findAll();
        echo $this->twig->render('form.html',
          [
            "user" => $user,
            "competences" => $competences
          ]
        );
      } else {
        header('Location: ?c=user&t=index');
      }
    }
  
    public function created(Request $request)
    {
        $post = $request->getPost();
        $em = $request->getEm();
        $user = $request->getUser();
        $tache = new Tache;
        $tache->setLibelle($post['titre']);
        $tache->setDescription($post['Description']);
        $date = new \DateTime($post['Date']);
        $tache->setDate($date);
        $tache->setUser($user);
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
    $get = $request->getGet();
    
    $competences = $em->getRepository("Entity\Competence")->findAll();
    $tache = $em->getRepository("Entity\Tache")->findOneBy([
        "id" => $get['id']
    ]);
    
    echo $this->twig->render('update.html',
      [
        "tache" => $tache,
        "competences" => $competences
      ]
    );
    
  }
  
  public function updated(Request $request)
  {
    $em = $request->getEm();
    $get = $request->getGet();
    $post = $request->getPost();
    
    $tache = $em->getRepository("Entity\Tache")->findOneBy([
        "id" => $get
    ]);

    $tache->removeCompetences($tache->getCompetences());
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
  
  public function remove(Request $request)
  {
    $em = $request->getEm();
    $get = $request->getGet();

    $tache = $em->getRepository("Entity\Tache")->findOneBy(["id" => $get["id"]]);
    $competences = $em->getRepository("Entity\Competence")->findAll();
    echo $this->twig->render('remove.html',
      [
        "tache" => $tache,
        "competences" => $competences
      ]
    ); 
  }
  
  public function deleted(Request $request)
  {
    $em = $request->getEm();
    $get = $request->getGet();

    $tache = $em->getRepository("Entity\Tache")->find($get["id"]); 
    $em->remove($tache);

    $em->flush();
    
    $this->list($request);
//     echo $this->twig->render('deleted.html',[]); 
  }
  
    public function listuser(Request $request)
{
      $user = $request->getUser();
      if (NULL ==! $user && $user->getIsConnected() == 1){ 
      
      $userid = $user->getId();

        $tacheRepository = $request->getEm()->getRepository('Entity\Tache');
        $taches = $tacheRepository->findBy(array("user" => $userid));       
        
        
        echo $this->twig->render('ListTacheUser.html',
          [
          "taches" => $taches,
          "quantity" => count($taches),
          "user"  =>  $user,
          ]
        );
      } else {
        header('Location: ?c=user&t=connected');
      }
    }
}