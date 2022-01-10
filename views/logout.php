<?php
session_start();
session_destroy();
echo 'Vous avez été déconnecté. <a href="http://192.168.40.78/applications/newmdpallagent/views/login.php"> Revenir en arrière </a>';