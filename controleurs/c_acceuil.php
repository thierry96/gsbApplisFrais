<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
if ($action == "vueAcceuil"){
       include("vues/v_accueil.php");
}
?>
