<?php
namespace Controllers;

use Entity\User;
use Entity\Request;

class UserController extends Controller
{
  
  public function index(Request $request)
  {
      $em = $request->getEm();      
      $user = $request->getUser();
    
      $eleves = $em->getRepository(User::class)->findBy([
      'tuteur' => $user->getId(),
    ]);
        
    
    if (null !== $user) {
      echo $this->twig->render('accueil.html', [
          'elevescount' => count($eleves), 
          'user'  =>  $user,
        
      ]);
    } 
    else {
       header('Location: ?c=user&t=connected'); 
    }
    
  }

  public function registration(Request $request)
  {             
    echo $this->twig->render('registration.html', []);
  }
  
  private function CheckForPasswordRegister($password1, $password2)
  {
    $result = 0;
    if ($password1 == $password2)
    $result = 1;
    return($result);
  }
  
  private function CheckForEmailWrong($email)
  {
    $result = false;
    if ( preg_match ( "^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$^" , $email ))
      $result = true;
    return($result);
  }
  
  public function registered(Request $request)
  {
    
    $em = $request->getEm();
    $user =  $em->getRepository(User::class)->findOneBy([
      
    'username' => $request->getPost()['username']
    ]);
    
    if (NULL != $user) {
      $created = "Cet utilisateur existe déjà";
      echo $this->twig->render('Authentification.html',["message" => $created]);
      die;
    }
    
    $created = "Erreur lors de la création de l'utilisateur";

    $SamePassWord = $this->CheckForPasswordRegister($request->getPost()['password1'],$request->getPost()['password2']);
    if ($SamePassWord == 0)
      $created = $created.", les mots de passe ne correspondent pas";
 
    $EmailIsGood = $this->CheckForEmailWrong($request->getPost()['email']);
    if (!$EmailIsGood)
      $created = $created.", l'email n'est pas bonne";
//     $EmailIsGood = 1;
    
    
    if ($SamePassWord == 1 && $EmailIsGood) {  
      $user = new User;
      $user->SetUsername($request->getPost()['username']);
      $user->SetPassword(base64_encode($request->getPost()['password1']));
      $user->SetEmail($request->getPost()['email']);
      $user->SetQuestion($request->getPost()['question']);
      $user->SetAnswer(base64_encode($request->getPost()['reponse']));
      $user->SetRole(1);
      $user->SetTuteur(0);
      $user->setIsConnected(false);
      $em->persist($user);
      $em->flush();
      $created = "Création de l'utilisateur réussi";
    }
      echo $this->twig->render('Authentification.html',["ParamAuthentification" => $created]);
  }
  
  public function connected(Request $request)
  {
    
      $post     =  $request->getPost();
      $em       =  $request->getEm();
      $message  =  NULL;
      $userActive = $request->getUser();
    
    if (NULL != $userActive){
      echo $this->twig->render('accueil.html', [
      'user'  =>  $userActive,
      ]);
      die;
    }
      
      if ( count($request->getPost()) > 0) {
       
          $user =  $em->getRepository(User::class)->findOneBy([
                'username'  =>  $post['username'],
          ]);

          if ( null !== $user ) {
            
              if ( base64_decode($user->getPassword()) == $post['password']) {

                  $user->setIsConnected(true);
                  $em->persist($user);
                  $em->flush();

                  //session_start();
                  $_SESSION['id'] = $user->getId();

                  header('Location: ?c=user&t=index');
                
              } else {

                 $message = "Mot de passe incorrect !";

              }

          } else {

              $message = "Le compte n'existe pas !";

          }

      }
      
      echo $this->twig->render('Authentification.html',[
               'message'  => $message
      ]);
    
  }
  
  public function deconnected(Request $request)
  {
    
     $em = $request->getEm();
     $user = $request->getUser();
     $user->setIsConnected(false);
     
     /**
     * Destruction de la session utilisateur
     */
//      session_start();
      
     $_SESSION = array();
       
     session_destroy();
     
     /**
      * Retour à l'index
      */
     header('Location: ?c=user&t=connected');
    
     
  }
  
  public function admin($request)
  {
    $em = $request->getEm()->getRepository('Entity\User');
    $users = $em->findall();
    
    $user = $request->getUser();
    
    if (NULL !== $user && $user->getRole() == 3) {
     echo $this->twig->render('adminpanel.html',
     [
       'users' => $users,
       'activeuser' => $user,
       'quantity' => count($users)
     ]);  
    } else {
      header('Location: ?c=user&t=index');
    }
      
  }
 
  public function lostpassword($request)
  {
    echo $this->twig->render('LostPassword.html', []);
  }
  
  public function lostusername($request)
  {
    echo $this->twig->render('LostUsername.html', []); 
  }
  
  public function changepasswordafterlost($request)
  {
    $em = $request->getEm();
    $post = $request->getPost();
    $get = $request->getGet();
    $message = "Cet utilisateur n'existe pas";
//     var_dump($post['password']); die;
    $newpassword = base64_encode($post['password']);
    $question = $post['question'];
    $answer = $post['reponse'];
    
    $user =  $em->getRepository(User::class)->findOneBy([
      'username' => $post['user'],
      'question' => $post['question'],
      'answer' => base64_encode($post['reponse'])
    ]);
      
    if (NULL ==! $user) {
      $user->SetPassword(base64_encode($newpassword));
      $message = "Le mot de passe a bien était changé pour l'utilisateur ".$user->getUsername();
      $em->persist($user);
      $em->flush();
    }
      
    echo $this->twig->render('Authentification.html',[
             'message'  => $message
    ]);       
  }
  
  public function getusernameafterlost($request)
  {

    $em = $request->getEm();
    $post = $request->getPost();
    $message = "Cet utilisateur n'existe pas";
    
    $email = $post['email'];
    $password = base64_encode($post['password']);
    $question = $post['question'];
    $answer = $post['reponse'];
    
    $user =  $em->getRepository(User::class)->findOneBy([
      'email' => $post['email'],
      'password' => base64_encode($post['password']),
      'question' => $post['question'],
      'answer' => base64_encode($post['reponse'])
    ]);
      
    if (NULL ==! $user) {
      $message = "Votre nom d'utilisateur est ".$user->getUsername();
    echo $this->twig->render('Authentification.html',[
             'message'  => $message
    ]);       
    } else {  
      header('Location: ?c=user&t=index');
    }
  }
    
  public function editbyadmin($request)
  {
    $em = $request->getEm();
    $post = $request->getPost();
    $get = $request->getGet();
    
    $user = $em->getRepository(User::class)->findOneBy([
      'id' => $get['id'],
    ]);
      
      if (NULL !== $user){
        $user->SetRole($post['rolechoice']);
        $em->persist($user);
        $em->flush();
        header('Location: ?c=user&t=admin');
    }
  }
  
  public function delete($request)
  {
    $em = $request->getEm();
    $get = $request->getGet(); 
    
    $user = $em->getRepository(User::class)->findOneBy([
      'id' => $get['id'],
    ]);
    
    if (NULL !== $user){
      $tacheRepository = $request->getEm()->getRepository('Entity\Tache');
      $taches = $tacheRepository->findBy(array("user" => $user->getId()));
      foreach ($taches as $tache) {
        $em->remove($tache);
        $em->flush();
      }
      
      $em->remove($user);
      $em->flush();
      $this->admin($request);
    }
  }
  
  public function addbyadmin($request)
  {
    $em = $request->getEm()->getRepository('Entity\User');
    $users = $em->findall();
    
    $user = $request->getUser();
    
    if (NULL ==! $user && $user->getRole() == 3) {
     echo $this->twig->render('CreateUserByAdmin.html', [
       'user' => $user,
     ] ); 
    } else {
      header('Location: ?c=user&t=index');
    }
  }
  
  public function createdbyadmin($request)
  {
    
    $em = $request->getEm();
    
    $user = $request->getUser();
    
    if (NULL ==! $user && $user->getRole() == 3) {
      $newuser = new User;
      $newuser->SetUsername($request->getPost()['username']);
      $newuser->SetPassword(base64_encode($request->getPost()['password1']));
      $newuser->SetEmail($request->getPost()['email']);
      $newuser->SetQuestion($request->getPost()['question']);
      $newuser->SetAnswer(base64_encode($request->getPost()['reponse']));
      $newuser->SetRole($request->getPost()['role']);
      $newuser->SetTuteur(0);
      $newuser->setIsConnected(false);
      $em->persist($newuser);
      $em->flush(); 
      header('Location: ?c=user&t=admin');
    } else {
      header('Location: ?c=user&t=index');
    }
  }
  
  public function TuteurPanel($request)
  {
    $em = $request->getEm()->getRepository('Entity\User');
    $user = $request->getUser();
    $userList = $em->findall();
    
    if (NULL ==! $user && $user->getRole() == 4) {
       echo $this->twig->render('UserListTuteur.html', [
         'user' => $user,
         'userlist' => $userList
     ] );
    }
  }
  
  public function SetTuteur($request)
  {
    $em = $request->getEm();
    $post = $request->getPost();
    $get = $request->getGet();
    $activeuser = $request->getUser();
    $user = $em->getRepository(User::class)->findOneBy([
      'id' => $get['id'],
    ]);
      
      if (NULL !== $user){
        $user->SetTuteur($activeuser->getId());
        $em->persist($user);
        $em->flush();
        header('Location: ?c=user&t=TuteurPanel');
    }
  }
  
  public function RemoveTuteur($request)
  {
    $em = $request->getEm();
    $post = $request->getPost();
    $get = $request->getGet();
    $activeuser = $request->getUser();
    $user = $em->getRepository(User::class)->findOneBy([
      'id' => $get['id'],
    ]);
      
      if (NULL !== $user){
        $user->SetTuteur(0);
        $em->persist($user);
        $em->flush();
        header('Location: ?c=user&t=TuteurPanel');
    }
  }
}