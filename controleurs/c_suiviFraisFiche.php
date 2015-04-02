<?php
/**
 * Cette page php constitu le controleur des actions qui seront mennées pour le suivi du paiement des fiches de frais.
 */
include("vues/v_sommaire.php");
// récupération de l'action 
$action = $_REQUEST['action'];

switch($action){
    case 'choixVisiteurEtMois':{
            // récupération du nom + du prénom des visiteurs
            $lesVisiteurs = $pdo->getLesVisiteurs();
            // récupération du premier visiteur dans la liste classé par ordre aplphabétique
            $idVisiteur = $pdo->getLeFirstVisiteur();
            $idVisiteur = $idVisiteur['id'] ;
            $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
            // Afin de sélectionner par défaut le dernier mois dans la zone de liste
            // on demande toutes les clés, et on prend la première,
            // les mois étant triés décroissants
            $lesCle = array_keys( $lesMois );
            $moisASelectionner = $lesCle[0];
            include ("vues/v_choixVisiteurEtMois.php");
            break;
    }
    case 'miseEnPaiement':{        
            $lesVisiteurs = $pdo->getLesVisiteurs();
            // récupération de l'id du visiteur qui a été choisi
            $idVisiteur = $_REQUEST['lstVisiteur']; 
            // récupération du nom et du prénom du visiteur choisi
            $leVisiteur = $pdo->getNomPrenom($idVisiteur) ;
            //récupération du mois sélectionné
            $leMois = $_REQUEST['lstMois'] ; 
            $lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
            $moisASelectionner = $leMois ;
            // transformation du mois choisi en format aaaamm
            $moisAng = getMoisAng($moisASelectionner); 
            // récupération des informations concernant la fiche du visiteur choisi en fonction
            //du mois sélectionné
            $infoVisiteur = $pdo->getLesInfosFicheFrais($idVisiteur , $moisAng);
            // récupération des informations des frais hors forfait du visiteur en question
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$moisAng);
            // variables globales pour connaitre la somme des frais forfaits et hors forfait
            $sommeFF = 0;
            $sommeFHF = 0;
            $lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$moisAng);
            // récupération des informations des frais forfaits du visiteur en question
            $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$moisAng);
            // test pour savoir si la fiche en suestion est la première du mois
            if ($pdo->estPremierFraisHorsForfaitMois($idVisiteur,$moisAng)) {
                $ok = TRUE;
            } else {
                $ok = FALSE;
            }
            if (!$pdo->estPremierFraisMois($idVisiteur , $moisAng)) {
                include ("vues/v_suiviFrais.php") ;
             } else {
                $message = $leVisiteur['nom']." ".$leVisiteur['prenom'] . " n'a pas de fiche de frais ce mois" ;
                include ("vues/v_information.php");
                include ("vues/v_choixVisiteurEtMois.php");
            }      
            break;
    }
    case 'paiementFiche':{
            // récupération de l'id du visiteur qui a été choisi
            $idVisiteur = $_REQUEST['idVisiteur'] ;
            // récupération du mois en format mmmmaa choisi.   
            $moisAng = $_REQUEST['mois'] ;  
            // déclaration d'une variable $etat    
            $etat = "VA" ;
            //mise à jour de la fiche de frais du visiteur choisi en fonction du mois   
            $pdo->majEtatFicheFrais($idVisiteur , $moisAng , $etat ) ; 
            // Récupération de la liste des visiteurs   
            $lesVisiteurs = $pdo->getLesVisiteurs();           
            // récupération du nom et du prénom du visiteur choisi
            $leVisiteur = $pdo->getNomPrenom($idVisiteur);
             // récupération des mois disponibles    
            $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
            // Récupération du mois en format aammmm   
            $moisASelectionner = getMoisFr($moisAng) ;
            // récupération des informations des frais forfait du visiteur en question
            $infoVisiteur = $pdo->getLesInfosFicheFrais($idVisiteur , $moisAng);
            // récupération des informations des frais hors forfait du visiteur en question    
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$moisAng);
            // variables globales pour connaitre la somme des frais forfaits et hors forfait   
            $sommeFF = 0;
            $sommeFHF = 0;
            $lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$moisAng);
            // test pour savoir si la fiche en suestion est la première du mois
            if ($pdo->estPremierFraisHorsForfaitMois($idVisiteur,$moisAng)) {
                $ok = TRUE;
            } else {
                $ok = FALSE;
            }
            include ("vues/v_suiviFrais.php") ;
            break;
    }
    case 'rembourserFiche':{        
            // récupération de l'id du visiteur qui a été choisi
            $idVisiteur = $_REQUEST['idVisiteur'] ;
            // récupération du mois en format mmmmaa choisi.   
            $moisAng = $_REQUEST['mois'] ;  
            // déclaration d'une variable $etat         
            $etat = "RB" ;
            //mise à jour de la fiche de frais du visiteur choisi en fonction du mois   
            $pdo->majEtatFicheFrais($idVisiteur , $moisAng , $etat ) ; 
            // Récupération de la liste des visiteurs   
            $lesVisiteurs = $pdo->getLesVisiteurs();           
            // récupération du nom et du prénom du visiteur choisi
            $leVisiteur = $pdo->getNomPrenom($idVisiteur);
            // récupération des mois disponibles    
            $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
            // Récupération du mois en format aammmm   
            $moisASelectionner = getMoisFr($moisAng) ;
            // récupération des informations des frais forfait du visiteur en question
            $infoVisiteur = $pdo->getLesInfosFicheFrais($idVisiteur , $moisAng);
            // récupération des informations des frais hors forfait du visiteur en question    
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$moisAng);
            // variables globales pour connaitre la somme des frais forfaits et hors forfait   
            $sommeFF = 0;
            $sommeFHF = 0;
            $lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$moisAng);
            // test pour savoir si la fiche en suestion est la première du mois
            if ($pdo->estPremierFraisHorsForfaitMois($idVisiteur,$moisAng)) {
                $ok = TRUE;
            } else {
                $ok = FALSE;
            }
            include ("vues/v_suiviFrais.php") ;
            break;
    }
} 
?>
