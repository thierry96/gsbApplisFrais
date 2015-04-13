<div id="contenu">
    <h2> Valider les fiches de frais  </h2>
    <h3>Visiteur et mois à sélectionner</h3>
    <form action="index.php?uc=suiviFraisFiche&action=miseEnPaiement" method="POST">
        <div class="corpsForm">
            <p>
            <label for="lstVisiteur">Visiteur :</label>
            <select name="lstVisiteur">
                <?php
                // parcour du tableau associatif lesVisiteur pour remplir la liste des visiteur
                    foreach ($lesVisiteurs as $unVisiteur) {
                        // récupération du nom dans la variable $nom
                        $nom = $unVisiteur['nom'];
                        // récupération du prénom dans la variable $prenom
                        $prenom = $unVisiteur['prenom'];
                        // récupération de l'id dans la variable $id
                        $id = $unVisiteur['id'];
                        if ($nom." ".$prenom == $leVisiteur['nom']." ".$leVisiteur['prenom']) {                                                      
                        ?>
                        <option selected value="<?php echo  $id ;  ?>"><?php echo  $nom." ".$prenom ;  ?> </option>
                        <?php
                         } else {
                        ?> 
                         <option  value="<?php echo  $id ; ?>"><?php echo  $nom." ".$prenom ; ?> </option>
                        <?php
                         }
                    }
                    ?>    
            </select>
            </p>
            <p>
            <label for="lstMois" accesskey="n">Mois : </label>
            <select id="lstMois" name="lstMois"> 
            
            <?php
            // Boucle pour le parcour du tableau associatif $lesMois
			foreach ($lesMois as $unMois)
			{
                            //récupération du mois au format aa/mmmm
			    $mois = $unMois['numMois']."/".$unMois['numAnnee'];
                            $numAnnee =  $unMois['numAnnee'];
                            $numMois =  $unMois['numMois'];
                            // condition pour savoir si le mois à la position t est égale au mois choisi
                            if($mois == $moisASelectionner){
                            ?>
                            <option selected value="<?php echo $mois ; ?>"><?php echo  $numMois."/".$numAnnee ; ?> </option>
                            <?php 
                            } else { ?>
                            <option value="<?php echo $mois ; ?>"><?php echo  $numMois."/".$numAnnee ; ?> </option>
                            <?php 
                            }	
			}        
		   ?>         
        </select>
            </p>          
        </div>
        <div class="piedForm">
         <p>
            <input id="ok" type="submit" value="Valider" size="20" />
         </p> 
      </div>
    </form> 
    <h3>Détail de la fiche de frais : <?php echo $leVisiteur['nom']." ".$leVisiteur['prenom'] ?> - 
    <?php echo $moisASelectionner ?> </h3>
   
    Etat: <?php echo $infoVisiteur['libEtat'] ; ?> depuis le <?php echo dateAnglaisVersFrancais($infoVisiteur['dateModif']) ; ?> <br />
    Montant validé : <?php echo $infoVisiteur['montantValide'] ; ?>
  
    <form method="POST"  action="index.php?uc=validerFraisFiche&action=validerMajFraisForfait">
      <div class="corpsForm">
          <input type="hidden" name="idVis" value="<?php echo $idVisiteur ; ?>" />
           <input type="hidden" name="leMois" value="<?php echo $moisAng ;  ?>" />
           <table class="listeLegere">
  	   <caption>Eléments forfaitisés </caption>
        <tr>
         <?php
         foreach ( $lesFraisForfait as $unFraisForfait ) 
		 {
			$libelle = $unFraisForfait['libelle'];
		?>	
			<th> <?php echo $libelle?></th>
		 <?php
        }
		?>
		</tr>
        <tr>
        <?php
          foreach (  $lesFraisForfait as $unFraisForfait  ) 
		  {
				$quantite = $unFraisForfait['quantite'];
                                $sommeFF += $quantite ;
		?>
                <td class="qteForfait"><?php echo $quantite?> </td>
		 <?php
          }
		?>
		</tr>
    </table>
          <h3>TOTAL DES ELEMENTS FORFAITISES : <?php echo $sommeFF ; ?></h3>
      </div>
        
    </form> 
    
    <div class="corpsForm"> 
        <input type="hidden" name="idVis" value="<?php echo $idVisiteur ; ?>" />
           <input type="hidden" name="leMois" value="<?php echo $moisAng ; ?>" />
      <table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait
       </caption>
             <tr>
               <th class="date">Date</th>
				<th class="libelle">Libellé</th>  
                <th class="montant">Montant</th>    
             </tr>
          
    <?php   
            if($ok = FALSE ) 
             {
                 ?> 
             <table><i><tr> Aucun frais hors forfait pour ce mois </tr></i></table>
             <?php } else {
                  foreach ( $lesFraisHorsForfait as $unFraisHorsForfait) {
			$libelle = $unFraisHorsForfait['libelle'];
			$date = $unFraisHorsForfait['date'];
			$montant=$unFraisHorsForfait['montant'];
                        $sommeFHF +=  $montant ;
	     ?>
             
            <tr>
                <td> <?php echo $date ;  ?></td>
                <td><?php echo $libelle ; ?></td>
                <td><?php echo $montant ; ?></td>
 
             </tr>

      <?php } 
            
       } ?></table> 		 
        <h3>TOTAL DES FRAIS HORS FORFAITS : <?php echo $sommeFHF ; ?> </h3>  
    </div> <br />

        <div class="piedForm">
            <?php if( $infoVisiteur['idEtat'] == "V") {
                ?>           
                <p><a href="index.php?uc=suiviFraisFiche&action=paiementFiche&idVisiteur=<?php echo $idVisiteur ; ?>&mois=<?php echo $moisAng ; ?>" 
                      title="Mettre en paiement la fiche de frais">Mise en paiement</a> <?php espace() ; ?>
           <?php } elseif ($infoVisiteur['idEtat'] == "VA") {  ?>
            
            <a href="index.php?uc=suiviFraisFiche&action=rembourserFiche&idVisiteur=<?php echo $idVisiteur ; ?>&mois=<?php echo $moisAng ; ?>" 
               title="Mettre la fiche de frais à l'état remboursée">Valider le paiement de cette fiche </a></p> 
            <?php }else { ?>
               <center> <h3>Etat de la fiche : <?php  echo $infoVisiteur['libEtat'] ;?> </h3</center>
            <?php } ?>    
        </div>
     
</div>  
