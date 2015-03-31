<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include("vues/v_sommaire.php");
// récupération de l'action 
$action = $_REQUEST['action'];

switch($action){
    case 'choixVisiteur':{
     $lesVisiteurs = $pdo->getLesVisiteurs();
     //$leFirst = $lesVisiteurs[0]['nom']+ " " + $lesVisiteurs[0]['prenom'] ;
     $idVisiteur = $pdo->getLeFirstVisiteur();
     $idVisiteur = $idVisiteur['id'] ;
     $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
     //$k = 1;
     // Afin de sélectionner par défaut le dernier mois dans la zone de liste
     // on demande toutes les clés, et on prend la première,
     // les mois étant triés décroissants
    $lesCle = array_keys( $lesMois );
     //if ($lesCles != NULL)
     //{
   $moisASelectionner = $lesCle[0];
     //}
     include ("vues/v_listeVisiteurEtMois.php");
     break;
    }
    case 'choixVisiteurEtMois':{
        $k = 0;
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $idVisiteur = $_REQUEST['lstVisiteur'];
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
       
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
        // récupération de l'id du visiteur qui a été choisi
        $idVisiteur = $_REQUEST['lstVisiteur']; 
        // récupération du nom et du prénom du visiteur choisi
        $leVisiteur = $pdo->getNomPrenom($idVisiteur);
        //récupération du mois sélectionné
        $leMois = $_REQUEST['lstMois']; 
	$lesMois=$pdo->getLesMois();
	$moisASelectionner = $leMois;
        // transformation du mois choisi en format aaaamm
        $MoisAng = getMoisAng($moisASelectionner);
        // récupération des informations concernant la fiche du visiteur choisi en fonction
        //du mois sélectionné
        $infoVisiteur = $pdo->getLesInfosFicheFrais($idVisiteur , $MoisAng);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$MoisAng);
         $sommeFF = 0;
         $sommeFHF = 0;
	$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$MoisAng);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$MoisAng);
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        //$montantFraisForfait = $pdo->getMontantTotalFicheFrais($idVisiteur,$MoisAng);
        if ($pdo->estPremierFraisHorsForfaitMois($idVisiteur,$MoisAng)){
            $ok = TRUE;
        }else{
            $ok = FALSE;
        }
        include ("vues/v_validerFrais.php") ;
    break;    
}
    case 'validerMajFraisForfait':{
		$lesFrais = $_REQUEST['lesFrais'];
		if(lesQteFraisValides($lesFrais)){
	  	 	$pdo->majFraisForfait($idVisiteur,$mois,$lesFrais);
		}
		else{
			ajouterErreur("Les valeurs des frais doivent être numériques");
			include("vues/v_erreurs.php");
		}
                 include ("vues/v_validerFrais.php") ;
     break;
}
    case 'supprimerFrais':{
		$idFrais = $_REQUEST['idFrais'];
	    $pdo->supprimerFraisHorsForfait($idFrais);
		break;
	}
    case 'validerJustificatif':{
        $lesVisiteurs = $pdo->getLesVisiteurs();
        // récupération de l'id du visiteur qui a été choisi
        //$idVisiteur = $_REQUEST['lstVisiteur']; 
        // récupération du nom et du prénom du visiteur choisi
         $leVisiteur = $pdo->getNomPrenom($idVisiteur);
        //récupération du mois sélectionné
        $leMois = $_REQUEST['lstMois']; 
	$lesMois=$pdo->getLesMois();
	$moisASelectionner = $leMois;
        // transformation du mois choisi en format aaaamm
        $MoisAng = getMoisAng($moisASelectionner);
        // récupération des informations concernant la fiche du visiteur choisi en fonction
        //du mois sélectionné
        $infoVisiteur = $pdo->getLesInfosFicheFrais($idVisiteur , $MoisAng);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$MoisAng);
	$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$MoisAng);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$MoisAng);
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        //$montantFraisForfait = $pdo->getMontantTotalFicheFrais($idVisiteur,$MoisAng);
        if ($pdo->estPremierFraisHorsForfaitMois($idVisiteur,$MoisAng)){
            $ok = TRUE;
        }else{
            $ok = FALSE;
        }
        $nb = $_REQUEST['nbJustificatif'];
        $pdo->majNbJustificatifs($idVisiteur,$MoisAng,$nb);
       include ("vues/v_validerFrais.php") ;
       break;
    }
}
?>
