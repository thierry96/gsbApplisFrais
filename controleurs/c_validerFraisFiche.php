   <?php

/**
 * Cette page php constitue le controleur des actions qui seront mennées pour la validation d'une fiche de frais.
 */
include("vues/v_sommaire.php");
// récupération de l'action 
$action = $_REQUEST['action'];
$page = "Validation"  ;
$lesFrais;
switch($action){
   case 'choixVisiteur':{
        // récupération de la liste des visiteurs(nom + prénom) sous forme de tableau associatifs
        $lesVisiteurs = $pdo->getLesVisiteurs();
        // récupération du premier visiteur de liste classée par ordre alphabétique
        $idVisiteur = $pdo->getLeFirstVisiteur();
        // récupération de l'id du premier visiteur
        $idVisiteur = $idVisiteur['id'] ;
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        //$k = 1;
        // Afin de sélectionner par défaut le dernier mois dans la zone de liste
        // on demande toutes les clés, et on prend la première,
        // les mois étant triés décroissants
        $lesCle = array_keys( $lesMois );
        // récupération du mois en cours du premier visiteur 
        $moisASelectionner = $lesCle[0];
        include ("vues/v_listeVisiteurEtMois.php");
        break;
   }
   case 'validerFrais': {
        // récupération de l'id du visiteur qui a été choisi
        $idVisiteur = $_REQUEST['lstVisiteur']; 
        //récupération du mois sélectionné
        $leMois = $_REQUEST['lstMois'] ;
        // récupération de l'information permettant de savoir si le comptable a changé de visiteur
        //dans la liste déroulante des visiteurs
        $modifListeVisteur = $_REQUEST['modifListeVisteur'] ;
        $lesVisiteurs = $pdo->getLesVisiteurs();       
        // récupération du nom et du prénom du visiteur choisi
        $leVisiteur = $pdo->getNomPrenom($idVisiteur) ;
	$lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
	$moisASelectionner = $leMois ;
        // transformation du mois choisi en format aaaamm
        $moisAng = getMoisAng($moisASelectionner); 
        // récupération des informations concernant la fiche du visiteur choisi en fonction
        //du mois sélectionné
        // récupération des informations de la fiche des frais hors forfaits du visiteur choisi en fonction du mois
        // variables globales pour connaitre la somme des frais forfaits et hors forfait
        $sommeFF = 0 ;
        $sommeFHF = 0 ;
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$moisAng); 
	      $lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$moisAng);
        // récupération des informations des frais forfaits du visiteur en question
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$moisAng); 
        // récupération du nombre de justificatif du mois
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        if ($pdo->estPremierFraisHorsForfaitMois($idVisiteur,$moisAng)) {
            $ok = TRUE;
        } else {
            $ok = FALSE;
        }
        if($modifListeVisteur === "Oui"){
           include ("vues/v_listeVisiteurEtMois.php"); 
        } else {
            // test pour savoir si la fiche en question est la première du mois
            if (!$pdo->estPremierFraisMois($idVisiteur , $moisAng)) {
                    include ("vues/v_listeVisiteurEtMois.php");
                    include ("vues/v_validerFrais.php") ;   
             } else {
                    // inclusion de la vue pour l'affichage de l'information
                    $message = $leVisiteur['nom']." ".$leVisiteur['prenom'] . " n'a pas de fiche de frais pour le mois de ".$moisASelectionner ;
                    include_once ("vues/v_information.php");
                    include_once ("vues/v_listeVisiteurEtMois.php");
            }
        }
        break;      
    }
    case 'validerMajFraisForfait':{
           if(isset($_POST['valid'])){ 
           // récupération des informations sur les frais forfaits   
           $lesFrais = $_REQUEST['lesFrais'];
           // récupération de l'id du visiteur choisi  
           $idVisiteur = $_REQUEST['idVis'] ;
           // récupération du mois choisi au format mmmmaa  
           $moisAng = $_REQUEST['leMois'] ;         
           // Si les frais forfaits validés respectent les conditions établies   
           if (lesQteFraisValides($lesFrais)) {
            // Mise à jour des éléments forfaitisés      
	  	        $pdo->majFraisForfait($idVisiteur,$moisAng,$lesFrais);
            } else {
            // ajout d'une erreur au tableau des erreurs      
	       	     ajouterErreur("Les valeurs des frais doivent être numériques");
		           include("vues/v_erreurs.php");
           }
            // récupération de la liste des visiteurs   
            $lesVisiteurs = $pdo->getLesVisiteurs();           
            // récupération du nom et du prénom du visiteur choisi
            $leVisiteur = $pdo->getNomPrenom($idVisiteur);  
            // récupération des mois disponibles du visiteur choisi   
            $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
            // récupération de la date choisi au format mmmmaa    
            $moisASelectionner = getMoisFr($moisAng) ;
            // initialisation de la variable $message avec l'information précisant que les modifications effectuées 
            // ont été prise en compte    
            $message = "Les modifications concernant la fiche de frais de " . $leVisiteur['nom']." ". $leVisiteur['prenom'] .
            " du mois de " . $moisASelectionner . " ont été prises en compte." ;
            // inclusion de la vues v_information pour l'affichage du message   
            include ("vues/v_information.php");
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$moisAng);
            // variables globales pour connaitre la somme des frais forfaits et hors forfait
            $sommeFF = 0;
            $sommeFHF = 0;
            $lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$moisAng);
            // récupération des informations des frais forfaits du visiteur en question
            $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$moisAng); 
            // récupération du nombre de justificatif du mois
            $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
            if ($pdo->estPremierFraisHorsForfaitMois($idVisiteur,$moisAng)) {
                $ok = TRUE;
            } else {
                $ok = FALSE;
            }
            include ("vues/v_validerFrais.php") ;
            break;
      }
}
    case 'supprimerFrais':{
            // récupération de l'id du frais correspondant à la ligne choisie
            $idFrais = $_REQUEST['idFrais'];
            // récupération du mois au format mmmmaa et de l'id du visiteur
            $moisAng = $_REQUEST['moisAng'] ;
            $idVisiteur = $_REQUEST['idVis'] ;
            // récupération des informations se trouvant à un tuple dans la base se données
            $infoFrais = $pdo->getLibelleFraisHorsForfait($idVisiteur , $moisAng , $idFrais) ;
            //récupération de la liste des visiteur (nom + prénom)
            $lesVisiteurs = $pdo->getLesVisiteurs();  
            // Teste pour savoir si un fiche existe pour un visiteur le mois suivant le mois qui a été choisi
            if ($pdo->estPremierFraisMois($idVisiteur , prochainMois($moisAng))) {
                // Création d'un nouvelle fiche avec pour valeur 0
                $pdo->creeNouvellesLignesFrais($idVisiteur , prochainMois($moisAng)) ;
                // ajout de la ligne de frais hors forfait refusé au prochain mois
                $pdo->creeNouveauFraisHorsForfait($idVisiteur,  prochainMois($moisAng), $infoFrais['libelle'] 
                   , dateAnglaisVersFrancais($infoFrais['date']), $infoFrais['montant']);
            } else {
                 $pdo->creeNouveauFraisHorsForfait($idVisiteur,  prochainMois($moisAng),
                 $infoFrais['libelle'], dateAnglaisVersFrancais($infoFrais['date']) 
                 , $infoFrais['montant']);
            }
            // ajout du texte REFUSE en début de libellé
            $pdo->ajouteRefuse($idFrais);
            // récupération du nom et du prénom du visiteur choisi
            // récupération du nom + prénom du visiteur choisi
            $leVisiteur = $pdo->getNomPrenom($idVisiteur);
            // récupération des mois disponible du visiteur pour remplir la comboBox
            $lesMois = $pdo->getLesMoisDisponibles($idVisiteur); 
            // modification du mois choisi au format aammmm
            $moisASelectionner = getMoisFr($moisAng) ;
            // récupération des informations des fiches de frais hors forfaits du visiteur en fonction du mois
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$moisAng);
            // initialisation des variables pour le calcul respectif des fraits forfaits et hors forfaits
            $sommeFF = 0;
            $sommeFHF = 0;
            // récupération des informations des frais  forfaits du visiteur en fonction du mois
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur,$moisAng);
            $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$moisAng);
            // récupération du nombre de justificatifs
            $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
            // condition pour savoir si les frais hors forfaits du visiteurs sont premières du mois ou pas
            if ($pdo->estPremierFraisHorsForfaitMois($idVisiteur,$moisAng)) {
                $ok = TRUE;
            } else {
                $ok = FALSE;
            }
            include ("vues/v_validerFrais.php") ;
            break;
	}
    case 'validerJustificatif':{
            // récupération du nombre de jsutificatif actuel
            $nb = $_REQUEST['nbJustificatif']; 
            // récupération de l'id du visiteur choisi et du mois choisi mais au format mmmmaa   
            $idVisiteur = $_REQUEST['idVis'] ;
            $moisAng = $_REQUEST['leMois'] ;
            // condition pour savoir si le nombre de justificatif est positif ou pas   
            if (estEntierPositif($nb)) {
             // mise à jour du nombre de justificatifs       
                $pdo->majNbJustificatifs($idVisiteur , $moisAng , $nb) ;            
            } else {
                // ajout d'un erreur au tableau des erreurs     
	             	ajouterErreur("Les valeurs des frais doivent être numériques");
                // affichage de l'erreur      
		            include("vues/v_erreurs.php");
            }
            // récupération de la liste des visiteurs dans la base de données   
            $lesVisiteurs = $pdo->getLesVisiteurs();           
            // récupération du nom et du prénom du visiteur choisi
            $leVisiteur = $pdo->getNomPrenom($idVisiteur);
            // récupération des mois disponibles d'un visiteur   
            $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
            // récupération du mois choisi au format aammmm   
            $moisASelectionner = getMoisFr($moisAng) ;
            // affichage du message stipulant qu'une modification a été effectuée   
            $message = "Les modifications concernant la fiche de frais de " . $leVisiteur['nom']." ". $leVisiteur['prenom'] . " du mois de " . $moisASelectionner . " ont été prises en compte." ;
            include ("vues/v_information.php");
            // récupération des informations concernant les fiches de frais du visiteur choisi  
            $infoVisiteur = $pdo->getLesInfosFicheFrais($idVisiteur , $moisAng);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$moisAng);
            $sommeFF = 0;
            $sommeFHF = 0;
            $lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$moisAng);
            $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$moisAng);
            $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
            if ($pdo->estPremierFraisHorsForfaitMois($idVisiteur,$moisAng)) {
                $ok = TRUE;
            } else {
                $ok = FALSE;
            }
            include ("vues/v_validerFrais.php") ;
            break;
    }
    case 'validerFiche':{        
            $idVisiteur = $_REQUEST['idVis'] ;
            $moisAng = $_REQUEST['leMois'] ;
            $montantV = $_REQUEST['montantValide'] ;
            $etat = "V" ;
            $pdo->majEtatFicheFrais($idVisiteur , $moisAng , $etat) ;
            $pdo->majMontantValide($idVisiteur , $moisAng , $montantV) ;
            $lesVisiteurs = $pdo->getLesVisiteurs();           
            // récupération du nom et du prénom du visiteur choisi
            $leVisiteur = $pdo->getNomPrenom($idVisiteur);        
            $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
            $moisASelectionner = getMoisFr($moisAng) ;
            $message = "Les modifications concernant la fiche de frais de " . $leVisiteur['nom']." ". $leVisiteur['prenom'] . " du mois de " . $moisASelectionner . " ont été prises en compte." ;
            include ("vues/v_information.php");
            $infoVisiteur = $pdo->getLesInfosFicheFrais($idVisiteur , $moisAng);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$moisAng);
            $sommeFF = 0;
            $sommeFHF = 0;
            $lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$moisAng);
            $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$moisAng);
            $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
            if ($pdo->estPremierFraisHorsForfaitMois($idVisiteur,$moisAng)) {
                $ok = TRUE;
            } else {
                $ok = FALSE;
            }
       include ("vues/v_validerFrais.php") ;
       break;
    }
    default :
        // récupération de la liste des visiteurs(nom + prénom) sous forme de tableau associatifs
        $lesVisiteurs = $pdo->getLesVisiteurs();
        // récupération du premier visiteur de liste classée par ordre alphabétique
        $idVisiteur = $pdo->getLeFirstVisiteur();
        // récupération de l'id du premier visiteur
        $idVisiteur = $idVisiteur['id'] ;
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        //$k = 1;
        // Afin de sélectionner par défaut le dernier mois dans la zone de liste
        // on demande toutes les clés, et on prend la première,
        // les mois étant triés décroissants
        $lesCle = array_keys( $lesMois );
        // récupération du mois en cours du premier visiteur 
        $moisASelectionner = $lesCle[0];
        include ("vues/v_listeVisiteurEtMois.php");
        break;
}
?>
