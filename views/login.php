<?php
include("../model/header.php");
require_once '../classes/database.php';
// if(!isset($_SESSION["user_login"]))	//check condition user login not direct back to index.php page
// {
// 	header("location: ../index.php");
// }

if(isset($_REQUEST['valider']))	//button name is "btn_login"
{
    // var_dump($_POST);  
	$email		= strip_tags($_REQUEST["email"]);	//textbox name "txt_username_email"
	$password	= strip_tags($_REQUEST["passwords"]);		//textbox name "txt_password"
	if(empty($email)){
		$errorMsg[]="Merci de saisir votre adresse email";	//check "email" textbox not empty
	}
	else if(empty($password)){
		$errorMsg[]="Veuillez entrer un mot de passe";	//check "passowrd" textbox not empty
	}
	else
	{
		try
		{
			$select_stmt=$conn->prepare("SELECT * FROM `agents` 
            WHERE agents.email=:uemail"
            ); 
            
            //sql select query
			$select_stmt->execute(array(':uemail'=>$email));	//execute query with bind parameter
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);	            
            // var_dump($row);   

			if($select_stmt->rowCount() > 0)	//check condition database record greater zero after continue
			{
				if($email==$row["email"]) //check condition user taypable "email" is match from database "email" after continue
				{
                    // Service IOPA = poles_services_id [7]
                    $_SESSION["user_pole"] = $row["poles_services_id"];
                    $service = $_SESSION["user_pole"]; 
                    // $autorisationPolerole = Id du service de l'utilisateur
                    // var_dump($autorisationPolerole);

                    $_SESSION["agentsid"] = $row["id"];
                    $agentsid = $_SESSION["agentsid"];   
                    // $agentsid = id de l'utilisateur qui se connecte
                    // var_dump($agentsid);
                    
                    $_SESSION["user_activity"] = $row["active"];
                    $active = $_SESSION["user_activity"]; 
                    // $active = Si l'utilisateur et toujour active dans la base de donnée 
                    // var_dump($row);
                    $rowAutorisationallMdpChange = $row["role_allMdpChange"];

                    if ($agentsid != ' ' && $active == "1") {
                        if($password==$row["passwords"]) //check condition user taypable "password" is match from database "password" using password_verify() after continue
                        {
                            try {
                                //Rechercher si une autorisation existe pour id de l'utilisateur 
                                // $select_stmt=$conn->prepare("SELECT *
                                // FROM `agents_has_applications` 
                                // WHERE applications_id = 2
                                // AND agents_id = :agentsid"
                                // );
                                //sql select query
                                // $select_stmt->execute(array(':agentsid'=>$agentsid));	//execute query with bind parameter
                                // $rowAutorisations=$select_stmt->fetchAll(PDO::FETCH_ASSOC);	                                    
                                    if ($rowAutorisationallMdpChange != 0 && $active == "1" ) {
                                            # Connexion depuis un compte admin
                                            $_SESSION["user_droit"] = $rowAutorisationallMdpChange;
                                            $userDroit = $_SESSION["user_droit"];   
                                            // var_dump($userDroit);
                                            $_SESSION["loggedIn"] = true;
                                            $loginMsg = "Connexion réussie...";		//user login success message
                                            header("refresh:2; ../index.php");			//refresh 2 second after redirect to "welcome.php" page
                                       			//refresh 2 second after redirect to "welcome.php" page
                                    } else {
                                        # Erreur interdiction de connexion l'utilisateur                                    
                                        $errorMsg[]="il semblerait que vous faisait quelque chose d'inhabituel";
                                    }     
                                                              
                            } 
                            catch(PDOException $e)
                            {
                                $e->getMessage();
                            }
                        }
                        else{                            
						$errorMsg[]="Le mot de passe n'existe pas";
                        }
                    }
					
					else
					{
						$errorMsg[]="Compte inactif";
					}
				}
				else
				{
					$errorMsg[]="Adresse email invalide";
				}
			}
			else
			{
				$errorMsg[]="Aucune entré vous correspondant";
			}
		}
		catch(PDOException $e)
		{
			$e->getMessage();
		}		
	}
}
?>
<!-- SCRIPT ICI -->
</head>
<body>
<div class="container">
    <div class="container d-flex mt-4 h-mini-90">
        <div class="col-lg-6 m-auto">
            <?php
            if(isset($errorMsg))
            {
                foreach($errorMsg as $error)
                {
                ?>
                    <div class="alert alert-danger">
                        <strong><?php echo $error; ?></strong>
                    </div>
                <?php
                }
            }
            if(isset($loginMsg))
            {
            ?>
                <div class="alert alert-success">
                    <strong><?php echo $loginMsg; ?></strong>
                </div>
            <?php
            }
            ?>
            <form action="" method="post" name="fo">
                <!-- <div class="erreur"><?php echo $erreur ?></div> -->                
                <div class="text-center col-12 mt-1">
                    <img  src="../public/images/logo.png" alt="logo du giep" width="110" height="72">
                </div>
                <div class="text-center">
                <h1><strong class="text-uppercase">Changement de mot de passe pour tous les agents</strong></a></h1>
                </div>
                <h2 class="h3 mb-3 font-weight-normal text-center">Veuillez vous connecter<hr></h2>
                <div class="form-group">
                    <label for="loginEmail" class="pb-1"><strong>Email :</strong></label>
                    <input type="email" class="form-control" id="loginEmail"  placeholder="Entrer votre email" name="email">
                </div>
                <div class="form-group pt-2">
                    <label for="Passwordid" class="pb-1"><strong>Mot de passe :</strong></label>
                    <input type="password" class="form-control" id="Passwordid" placeholder="Entrer votre mot de passe" name="passwords">
                </div>
                <div class="text-center  mb-3">
                <button class="btn btn-lg btn btn-primary btn-block mt-4 text-center" type="submit" name="valider" value="S'authentifier" style="background-color:#2e4f9b;color:white;">S'identifier</button>
                </div> 
            </form>
<?php include("../model/footer.php");?>
