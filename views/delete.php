<?php
//Ne pas oublier d'ajouter le fichier posts.php

?>
<?php require '../model/header.php';?>
    <?php  
        require '../classes/posts.php';
        $deletePost = new Post();
        $getPoste = new Post();
        $deletePosts = $deletePost->setDelete($_GET['id']);
        $getPostes = $getPoste->getPost($_GET['id']);
        $getPoste = $getPostes->fetch(); 
        ?>
<?php require '../model/footer.php';?>