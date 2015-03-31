    <!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    
        <h2>
    
</h2>
    
      </div>  
        <ul id="menuList">
			<li>
				<br />
                                <h2><strong><?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?></strong></h2>
                                <h3><strong><?php echo $_SESSION['profil'] ?></strong><h3>
			</li>
        <?php if ($_SESSION['profil'] == "Visiteur Médicale"){ ?> 
           <li class="smenu">
              <a href="index.php?uc=acceuil&action=vueAcceuil" title="Accueil">Acceuil</a>
           </li>             
           <li class="smenu">
              <a href="index.php?uc=gererFrais&action=saisirFrais" title="Saisie fiche de frais ">Saisie fiche de frais</a>
           </li>
           <li class="smenu">
              <a href="index.php?uc=etatFrais&action=selectionnerMois" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
           </li>
         <?php } else { ?>
           <li class="smenu">
              <a href="index.php?uc=acceuil&action=vueAcceuil" title="Accueil">Acceuil</a>
           </li> 
           <li class="smenu">
              <a href="index.php?uc=validerFraisFiche&action=choixVisiteur"title="Valider les fiches de frais ">Valider les fiches de frais</a>
           </li>
           <li class="smenu">
              <a href="index.php?uc=suiviFraisFiche&action=" title="Consultation de mes fiches de frais">Suivi du paiement des fiches</a>
           </li>
         <?php } ?>
 	   <li class="smenu">
              <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
           </li>
         </ul>
        
    </div>
    