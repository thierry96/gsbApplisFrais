<?php
/**
 * Cette page php constitu le controleur des actions qui seront mennées pour la gestion de la connexion à l'intranet du laboratoire GSB.
 * @package Default
 * @author ADJOUA Sam Thierry  <thierryadjoua@yahoo.fr>
 */
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
switch($action){
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
	case 'valideConnexion':{
		$login = $_REQUEST['login'];
		$mdp = $_REQUEST['mdp'];
		$visiteur = $pdo->getInfosVisiteur($login,$mdp);
		if(!is_array( $visiteur)){
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
		else{
			$id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
                        $profil = $visiteur['profil'];
			connecter($id,$nom,$prenom,$profil);
			include("vues/v_sommaire.php");
                        include("vues/v_accueil.php");
		}
		break;
	}
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>