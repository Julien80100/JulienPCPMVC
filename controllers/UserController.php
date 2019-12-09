<?php
namespace Controllers;

use Entity\User;
use Entity\Request;

class UserController extends Controller
{
  
  public function index(Request $request)
  {
      
      $user = $request->getUser();
    
    if (null !== $user) {
      echo $this->twig->render('accueil.html', [
          
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
    $result = 0;
    if ( preg_match ( " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ " , $email ) )
      $Result = 1;
    return($result);
  }
  
  public function registered(Request $request)
  {
    $created = "Erreur lors de la création de l'utilisateur";

    $SamePassWord = $this->CheckForPasswordRegister($request->getPost()['password1'],$request->getPost()['password2']);
    if ($SamePassWord == 0)
      $created = $created.", les mots de passe ne correspondent pas";
 
    $EmailIsGood = $this->CheckForEmailWrong($request->getPost()['email']);
    if ($EmailIsGood == 0)
      $created = $created.", l'email n'est pas bonne";
    
    if ($SamePassWord == 1 && $EmailIsGood == 1) {  
      $user = new User;
      $user->SetUsername($request->getPost()['username']);
      $user->SetPassword($request->getPost()['password1']);
      $user->SetEmail($request->getPost()['email']);
      $user->SetRole(1);
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
      $message  =  null;
      
      if ( count( $request->getPost() ) > 0 ) {
       
          $user =  $em->getRepository(User::class)->findOneBy([
                'username'  =>  $post['User'],
          ]);

          if ( null !== $user ) {
            
              if ( $user->getPassword() == $post['password'] ) {

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
  
}