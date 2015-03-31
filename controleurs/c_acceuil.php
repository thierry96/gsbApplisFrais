<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
if ($action == "vueAcceuil"){
       include("vues/v_accueil.php");
}
?>
