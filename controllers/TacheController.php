<?php
namespace Controllers;
use Models\Taches;
use Entity\Tache;
use Entity\Request;
class TacheController extends Controller
{
    public function index()
    {
        header('Location: ?c=user&t=connected');
    }
  
    public function list(Request $request)
{
      $user = $request->getUser();
      if (NULL ==! $user && $user->getIsConnected() == 1 && $user->getrole() == 3){ 


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
        header('Location: ?c=tache&t=listuser');
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
        $tache->setIsVeille(False);
        $tache->SetValidebytuteur(false);
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
        header('Location: ?c=tache&t=listuser');
      
    }
  
  public function edit(Request $request)
  {
    
    $em = $request->getEm();
    $get = $request->getGet();
    $user = $request->getUser();
    
    $competences = $em->getRepository("Entity\Competence")->findAll();
    $tache = $em->getRepository("Entity\Tache")->findOneBy([
        "id" => $get['id']
    ]);
    if ($tache->getValidebytuteur() == 0)
    {
      echo $this->twig->render('update.html',
        [
          "user" => $user,
          "tache" => $tache,
          "competences" => $competences
        ]
      );
    } else {
      header('Location: ?c=user&t=connected');
    }
    
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
    header('Location: ?c=tache&t=listuser');
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
      if (NULL ==! $user && $user->getIsConnected() == 1 ){ 
      
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
  
  public function listtuteur($request)
  {

      $user = $request->getUser();
      $userid = $user->getId();
      if (NULL ==! $user && $user->getIsConnected() == 1 && $user->getRole() == 4){ 
        $tacheRepository = $request->getEm()->getRepository('Entity\Tache');
        $competenceRepository = $request->getEm()->getRepository('Entity\Competence');       
        
        $tuteuruser = $request->getEm()->getRepository('Entity\User')->findOneBy([
      'tuteur' => $userid
      ]);

      $taches = $tacheRepository->findBy(["user" => $tuteuruser, "isveille" => 0]);
      $competences = $competenceRepository->findAll();
          // var_dump($taches); die;
        echo $this->twig->render('listtachetuteur.html',
          [
          "taches" => $taches,
          "quantity" => count($taches),
          "user"  =>  $user,
          "eleve" => $tuteuruser,
          "competences" => $competences
          ]
        );
      } else {
        header('Location: ?c=user&t=connected');
      }
  }

  public function validebytuteur($request)
  {
    $get = $request->getGet();
    $user = $request->getUser();
    $em = $request->getEm();

    if (NULL ==! $user && $user->getRole() == 4)
    {
    $tache = $em->getRepository("Entity\Tache")->find($get["id"]);

    $tache->setValidebytuteur(True);

      $em->persist($tache);
      $em->flush();

    header('Location: ?c=tache&t=listtuteur');
    } else {
      header('Location: ?c=user&t=connected');
    }
  }

  public function invalidebytuteur($request)
  {
    $get = $request->getGet();
    $user = $request->getUser();
    $em = $request->getEm();

    if (NULL ==! $user && $user->getRole() == 4)
    {
    $tache = $em->getRepository("Entity\Tache")->find($get["id"]);

    $tache->setValidebytuteur(False);

      $em->persist($tache);
      $em->flush();

    header('Location: ?c=tache&t=listtuteur');
    } else {
      header('Location: ?c=user&t=connected');
    }
  }

  public function listveilletuteur($request)
  {
    $user = $request->getUser();
    $userid = $user->getId();
    if (NULL ==! $user && $user->getIsConnected() == 1 && $user->getRole() == 4){ 
      $tacheRepository = $request->getEm()->getRepository('Entity\Tache');       
      
      $tuteuruser = $request->getEm()->getRepository('Entity\User')->findOneBy([
    'tuteur' => $userid
    ]);

    $taches = $tacheRepository->findBy(["user" => $tuteuruser, "isveille" => 1]);

      echo $this->twig->render('listveilletuteur.html',
        [
        "taches" => $taches,
        "quantity" => count($taches),
        "user"  =>  $user,
        "eleve" => $tuteuruser,
        ]
      );
    } else {
      header('Location: ?c=user&t=connected');
    }  
  }

  public function listveilletechnologique($request)
  {
    $user = $request->getUser();
    $veilleRepository = $request->getEm()->getRepository('Entity\Tache');
    $veilles = $veilleRepository->findBy(["user" => $user, "isveille" => 1]);
    if ( NULL != $user && $user->getRole() == 2 || $user->getRole() == 3)
    {
      echo $this->twig->render('listveille.html',
      [
      "user"  =>  $user,
      "veilles" => $veilles,
      "quantity" => count($veilles)
      ]
      );
    }

  }

  public function veilletechnologique($request)
  {
    $user = $request->getUser();
    if ( NULL != $user && $user->getRole() == 2 || $user->getRole() == 3)
    {
      echo $this->twig->render('createveille.html',
      [
      "user"  =>  $user,
      ]
      );
    }
  }

  public function createveille($request)
  {
    $user = $request->getUser();
    if ( NULL != $user && $user->getRole() == 2 || $user->getRole() == 3)
    {
      $post = $request->getPost();
      $em = $request->getEm();
      $veille = new Tache;
      $veille->setLibelle($post['titre']);
      $veille->setDescription($post['Description']);
      $date = new \DateTime($post['Date']);
      $veille->setDate($date);
      $veille->setUser($user);
      $veille->setIsveille(1);
      $veille->setValidebytuteur(false);
      $em->persist($veille);
      $em->flush();

      header('Location: ?c=tache&t=listveilletechnologique');
    
    } else {
      header('Location: ?c=user²t=connected');
    }
  }

  public function editveille($request)
  {
    
    $em = $request->getEm();
    $get = $request->getGet();
    $user = $request->getUser();
    
    $veille = $em->getRepository("Entity\Tache")->findOneBy([
        "id" => $get['id']
    ]);

    if ( NULL ==! $veille && $veille->getIsveille() == 1)
    {
      echo $this->twig->render('editveille.html',
        [
          "user" => $user,
          "veille" => $veille
        ]);

    } else {
      header('Location: ?c=user&t=connected');
    }
  }

  public function updatedveille($request)
  {
    $em = $request->getEm();
    $get = $request->getGet();
    $post = $request->getPost();
    
    $veille = $em->getRepository("Entity\Tache")->findOneBy([
        "id" => $get['id']
    ]);
// var_dump($post);die;
    $veille->setLibelle($post['titre']);
    $veille->setDescription($post['Description']);
    $date = new \DateTime($post['Date']);
    $veille->setDate($date);
    $em->persist($veille);
    $em->flush(); 
    header('Location: ?c=tache&t=listveilletechnologique');
  }

  public function valideveillebytuteur($request)
  {
    $get = $request->getGet();
    $user = $request->getUser();
    $em = $request->getEm();

    if (NULL ==! $user && $user->getRole() == 4)
    {
    $tache = $em->getRepository("Entity\Tache")->find($get["id"]);

    $tache->setValidebytuteur(True);

      $em->persist($tache);
      $em->flush();

    header('Location: ?c=tache&t=listveilletuteur');
    } else {
      header('Location: ?c=user&t=connected');
    }
  }

  public function invalideveillebytuteur($request)
  {
    $get = $request->getGet();
    $user = $request->getUser();
    $em = $request->getEm();

    if (NULL ==! $user && $user->getRole() == 4)
    {
    $tache = $em->getRepository("Entity\Tache")->find($get["id"]);

    $tache->setValidebytuteur(False);

      $em->persist($tache);
      $em->flush();

    header('Location: ?c=tache&t=listveilletuteur');
    } else {
      header('Location: ?c=user&t=connected');
    }
  }
}