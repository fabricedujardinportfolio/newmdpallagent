<?php
//Ne pas oublier d'ajouter le fichier posts.php

?>
<?php require '../model/header.php';?>
    <?php  
        require '../classes/posts.php';
        $updatePoste = new Post();        
        $dateStart = date_format($_GET['date_start'], 'Y-m-d');
        $updatePoste = $updatePoste->setUpdate($_GET['id'],$dateStart,$_GET['date_end'],$_GET['motif']);
        ?>
<?php require '../model/footer.php';?>