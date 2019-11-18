<html>
  <head>
    <title>Creation de tache</title>
  </head>
  
  <body>
    <?php
      use Entity\Tache;
      require_once "bootstrap.php";

      $newTacheTitle = $argv[1];

      $tache = new Tache();
      $tache->setDescription($newTacheDescription);

      $entityManager->persist($tache);
      $entityManager->flush();
      echo "Created Tache with ID " . $tache->getId() . "\n"; 
    ?>    
  </body>
</html>