<?php
/** 
 * Fonctions pour l'application GSB
 
 * @package default
 * @author ADJOUA Sam Thierry
 * @version    1.0
 */

 /**
 * Teste si un quelconque visiteur est connecté
 * @return vrai ou faux 
 */
function estConnecte(){
  return isset($_SESSION['idVisiteur']);
}
/**
 * Enregistre dans une variable session les infos d'un visiteur
 
 * @param $id 
 * @param $nom
 * @param $prenom
 * @param $profil
 */
function connecter($id,$nom,$prenom,$profil){
	$_SESSION['idVisiteur']= $id; 
	$_SESSION['nom']= $nom;
	$_SESSION['prenom']= $prenom;
        $_SESSION['profil']= $profil;
}
/**
 * Détruit la session active
 */
function deconnecter(){
	session_destroy();
}
/**
 * Transforme une date au format français jj/mm/aaaa vers le format anglais aaaa-mm-jj
 
 * @param $madate au format  jj/mm/aaaa
 * @return String la date au format anglais aaaa-mm-jj
*/
function dateFrancaisVersAnglais($maDate){
	@list($jour,$mois,$annee) = explode('/',$maDate);
	return date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
}
/**
 * Transforme une date au format format anglais aaaa-mm-jj vers le format français jj/mm/aaaa 
 
 * @param $madate au format  aaaa-mm-jj
 * @return String la date au format format français jj/mm/aaaa
*/
function dateAnglaisVersFrancais($maDate){
   @list($annee,$mois,$jour)=explode('-',$maDate);
   $date="$jour"."/".$mois."/".$annee;
   return $date;
}
/**
 * retourne le mois au format aaaamm selon le jour dans le mois
 
 * @param $date au format  jj/mm/aaaa
 * @return String  le mois au format aaaamm
*/
function getMois($date){
		@list($jour,$mois,$annee) = explode('/',$date);
		if(strlen($mois) == 1){
			$mois = "0".$mois;
		}
		return $annee.$mois;
}
/**
 * retourne le mois au format aaaamm en fonction du mois au format mmaaaa
 * @author Sam Thierry <thierryadjoua@yahoo.fr>
 * @param $date au format mmaaaa
 * @return String le mois au format aaaamm
 */
function getMoisAng($date){
    $chaine = substr($date, 0 , 2);
    $chaine2 = substr($date, 3 , 7);
    return $chaine2."".$chaine;
}
/**
 * retourne le mois au format mmaaaa en fonction du mois au format aaaamm
 * @author Sam Thierry <thierryadjoua@yahoo.fr>
 * @param $date au format aaaamm
 * @return String le mois au format mmaaaa
 */
function getMoisFr($date){
    $chaine = substr($date, 0 , 4);
    $chaine2 = substr($date, 4 , 7);
    return $chaine2."/".$chaine;
}
/* gestion des erreurs*/
/**
 * Indique si une valeur est un entier positif ou nul
 
 * @param $valeur
 * @return vrai ou faux
*/
function estEntierPositif($valeur) {
	return preg_match("/[^0-9]/", $valeur) == 0;
	
}
/**
 * Indique si un tableau de valeurs est constitué d'entiers positifs ou nuls
 
 * @param $tabEntiers : le tableau
 * @return vrai ou faux
*/
function estTableauEntiers($tabEntiers) {
	$ok = true;
	foreach($tabEntiers as $unEntier){
		if(!estEntierPositif($unEntier)){
		 	$ok=false; 
		}
	}
	return $ok;
}
/**
 * Vérifie si une date est inférieure d'un an à la date actuelle
 
 * @param $dateTestee 
 * @return vrai ou faux
*/
function estDateDepassee($dateTestee){
	$dateActuelle=date("d/m/Y");
	@list($jour,$mois,$annee) = explode('/',$dateActuelle);
	$annee--;
	$AnPasse = $annee.$mois.$jour;
	@list($jourTeste,$moisTeste,$anneeTeste) = explode('/',$dateTestee);
	return ($anneeTeste.$moisTeste.$jourTeste < $AnPasse); 
}
/**
 * Vérifie la validité du format d'une date française jj/mm/aaaa 
 
 * @param $date 
 * @return vrai ou faux
*/
function estDateValide($date){
	$tabDate = explode('/',$date);
	$dateOK = true;
	if (count($tabDate) != 3) {
	    $dateOK = false;
    }
    else {
		if (!estTableauEntiers($tabDate)) {
			$dateOK = false;
		}
		else {
			if (!checkdate($tabDate[1], $tabDate[0], $tabDate[2])) {
				$dateOK = false;
			}
		}
    }
	return $dateOK;
}

/**
 * Vérifie que le tableau de frais ne contient que des valeurs numériques 
 
 * @param $lesFrais 
 * @return vrai ou faux
*/
function lesQteFraisValides($lesFrais){
	return estTableauEntiers($lesFrais);
}
/**
 * Vérifie la validité des trois arguments : la date, le libellé du frais et le montant 
 
 * des message d'erreurs sont ajoutés au tableau des erreurs
 
 * @param $dateFrais 
 * @param $libelle 
 * @param $montant
 */
function valideInfosFrais($dateFrais,$libelle,$montant){
	if($dateFrais==""){
		ajouterErreur("Le champ date ne doit pas &ecirc;tre vide");
	}
	else{
		if(!estDatevalide($dateFrais)){
			ajouterErreur("Date invalide");
		}	
		else{
			if(estDateDepassee($dateFrais)){
				ajouterErreur("date d'enregistrement du frais dépassé, plus de 1 an");
			}			
		}
	}
	if($libelle == ""){
		ajouterErreur("Le champ description ne peut pas être vide");
	}
	if($montant == ""){
		ajouterErreur("Le champ montant ne peut pas être vide");
	}
	else
		if( !is_numeric($montant) ){
			ajouterErreur("Le champ montant doit être numérique");
		}
}
/**
 * Ajoute le libellé d'une erreur au tableau des erreurs 
 
 * @param $msg : le libellé de l'erreur 
 */
function ajouterErreur($msg){
   if (! isset($_REQUEST['erreurs'])){
      $_REQUEST['erreurs']=array();
	} 
   $_REQUEST['erreurs'][]=$msg;
}
/**
 * Retoune le nombre de lignes du tableau des erreurs 
 
 * @return le nombre d'erreurs
 */
function nbErreurs(){
   if (!isset($_REQUEST['erreurs'])){
	   return 0;
	}
	else{
	   return count($_REQUEST['erreurs']);
	}
}
/**
 * Affichage d'espaces
 * @author Sam Thierry <thierryadjoua@yahoo.fr>
 * @param  $nbEspaces nombre d'espaces à afficher
 */     
function espace($nbEspaces=1) {
  for ($k=0 ; $k<$nbEspaces ; $k++) {
    echo "&nbsp;" ;
  }
}  
 /**
  * Fait un retour à la ligne
  * @author Sam Thierry <thierryadjoua@yahoo.fr>
  * @param $nbLigne nombre de retour à ligne 
  */
  function retourLigne($nbLigne){
      for ($k = 0 ; $k < $nbLigne ; $k++){
          echo "<br />";
      }
  }
  /**
  * Retourne le mois suivant en fonction du mois passé en paramètre au format mmmmaa
  * @author Sam Thierry <thierryadjoua@yahoo.fr>
  * @param  $mois  
  * @return $mois
  */
  function prochainMois($mois){
      $numMois = (int)  substr($mois, 4 , 7);
      $numAnnee = (int) substr($mois, 0 , 4);
      if (($numMois < 10) && ($numMois < 9)) {
          $numMois += 1 ;
          $numMois = "0".$numMois;
      } elseif (($numMois >= 10) && ($numMois < 12)) {
         $numMois += 1 ;
      } elseif ($numMois == 9) {
          $numMois += 1 ;
      } elseif ($numMois == 12) {
          $numMois = "01" ;
          $numAnnee +=1 ;
      }  
      return $numAnnee."".$numMois ;
  }
?>  