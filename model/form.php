<?php
if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == false) :
?>
<?php
  header("refresh:0; views/login.php");
else :
  //  Affichage du formulaire pour compte utilisateur simple de l'application numéro vert 
  try {
    $select_stmt = $conn->prepare("SELECT * FROM `agents`");
    $select_stmt->execute();
    $userInfos = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($userInfos);
  } catch (PDOException $e) {
    $e->getMessage();
  }
  if (isset($_REQUEST['valider'])) {

    $select_stmt = $conn->prepare("SELECT * FROM `agents` where passwords = 123456");
    $select_stmt->execute();
    $userInfosChanges = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($userInfosChanges);
    foreach ($userInfosChanges as $userInfosChange) {
      // var_dump($userInfosChange['id']);
      try {
        $userEmail = $userInfosChange['email'];
        // var_dump($userEmail);
        $userId = $userInfosChange['id'];
        $bytes = openssl_random_pseudo_bytes(4);
        $pass = bin2hex($bytes);
        // echo $pass;
        $stmt = $conn->prepare("UPDATE `agents` SET passwords = ? WHERE id = '$userId'");
        $stmt->execute([$pass]);
        $to = $userEmail;
        $subject = 'Changement de mot de passe';
        $lienshtml='http://mot-de-passe/'; 
        $message = "Bonjour,
        Vous trouverez dans ce courriel la procédure pour vous connecter aux applications GIEP-NC suivantes :
        -  Ressources (application à destination des agents du GIEP-NC afin d'effectuer une réservation de véhicules, de salles de réunion, formation,  ou de matériel informatique)
        -  Numéro vert (application à destination du pôle Information Orientation)
        -  Absences (application à destination du service RH)
        
        1/ Depuis l'Intranet, allez dans le menu 'Applications Métiers'
        2/ Sélectionnez l'application que vous souhaitez utiliser (Numéro vert, Absences ou Ressources ) 
        3/ Pour vous authentifier, utilisez votre adresse email GIEP-NC ainsi que le mot de passe suivant : '$pass'
        4/ Une fois authentifié, allez sur le menu 'changer mon mot de passe' afin de saisir un mot de passe dont vous vous souviendrez. 
        Cette procédure de changement de mot de passe peut être effectuée à tout moment depuis l'url : '$lienshtml'

        Merci
        Bonne journée"; 
        // echo $message;    
        if (mail($to, $subject, $message)) {
          // echo 'Votre message a été envoyé avec succès!';   
        } else {
          $errorMsg[] = "L'envoie de email à planter";
        }
        
      } catch (PDOException $e) {
        $e->getMessage();
      }
    }
  }
?>
  <?php

  if (isset($loginMsg)) {
  ?>
    <div class="alert alert-success">
      <strong><?php echo $loginMsg; ?></strong>
    </div>
  <?php
  }
  ?>
  <form action="" method="post">
    <p><button type="submit" class="btn btn-primary" name="valider">Changer les mots de passe</button></p>
  </form>
  <div class="table-responsive">
    <table class="table table-bordered border-primary">
      <caption>Liste des agents </caption>
      <thead>
        <tr>
          <th scope="col">Prénom</th>
          <th scope="col">Nom</th>
          <th scope="col">MDP</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // var_dump(count($userInfos));
        // $i = 0;
        foreach ($userInfos as $userInfo) {
          # code...
          // // var_dump($userInfo);
          // echo $i;
          // $i++;
        ?>
          <tr>
            <td><?php echo $userInfo['first_name'] ?></td>
            <td><?php echo $userInfo['name'] ?></td>
            <td><?php echo $userInfo['passwords'] ?></td>
          </tr>
        <?php
        }

        ?>
      </tbody>
    </table>
  </div>
<?php
endif;
