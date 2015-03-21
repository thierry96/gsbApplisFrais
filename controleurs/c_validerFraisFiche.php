<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include("vues/v_sommaire.php");
// récupération de l'action 
$action = $_REQUEST['action'];

switch($action){
    case 'choixVisiteurEtMois':{
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $lesMois = $pdo->getLesMois();
	// Afin de sélectionner par défaut le dernier mois dans la zone de liste
	// on demande toutes les clés, et on prend la première,
	// les mois étant triés décroissants
        $lesCles = array_keys( $lesMois );
	$moisASelectionner = $lesCles[0];
        include ("vues/v_listeVisiteurEtMois.php");
    break;    
}
    case 'validerFrais':{
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $leVisiteur = $_REQUEST['lstVisiteur']; 
        $leMois = $_REQUEST['lstMois']; 
	$lesMois=$pdo->getLesMois();
	$moisASelectionner = $leMois;
        include ("vues/v_validerFrais.php") ;
    break;    
}
}
?>
