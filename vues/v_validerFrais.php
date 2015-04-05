
<div id="contenu">
    <h2> Valider les fiches de frais  </h2>
    <h3>Visiteur et mois à sélectionner</h3>
    <form action="index.php?uc=validerFraisFiche&action=validerFrais" method="POST">
        <div class="corpsForm">
            <p>
            <label for="lstVisiteur">Visiteur :</label>
            <select name="lstVisiteur">
                <?php 
                     // parcour du tableau associatif les visiteurs
                    foreach ($lesVisiteurs as $unVisiteur){
                        // récupération du nom dans la variable $nom
                        $nom = $unVisiteur['nom'];
                        // récupération du prenom dans la variable $prenom
                        $prenom = $unVisiteur['prenom'];
                        // récupération de l'id dans la variable $id
                        $id = $unVisiteur['id'];
                        //condition pour savoir si le visiteur se trouvant à la position t est égale au visiteur choisi
                        if ($nom." ".$prenom === $leVisiteur['nom']." ".$leVisiteur['prenom']) {                                                      
                        ?>
                        <option selected value="<?php echo  $id ; ?>"><?php echo  $nom." ".$prenom ; ?> </option>
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
            // parcour du tableau associatif $lesMois
			foreach ($lesMois as $unMois)
			{
                            // récupération du mois au format aa/mmmm
			    $mois = $unMois['numMois']."/".$unMois['numAnnee'];
                            $numAnnee =  $unMois['numAnnee'];
                            $numMois =  $unMois['numMois'];
                            if ($mois === $moisASelectionner) {
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
   <h3>Détail de la fiche de frais : <?php echo $leVisiteur['nom']." ".$leVisiteur['prenom'] ;  ?> - 
   <?php echo $moisASelectionner ;  ?> </h3>
   
    Etat: <?php echo $lesInfosFicheFrais['libEtat']; ?> 
    depuis le <?php echo dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']) ; ?> <br />
    Montant validé : <?php echo $lesInfosFicheFrais['montantValide'] ; ?>
    <!-- Affichage des informations liée aux élements forfaitisés -->
    <form method="POST"  action="index.php?uc=validerFraisFiche&action=validerMajFraisForfait">
      <div class="corpsForm">
          <input type="hidden" name="idVis" value="<?php echo $idVisiteur ; ?>" />
           <input type="hidden" name="leMois" value="<?php echo $moisAng ;  ?>" />
          <fieldset>
            <legend>Eléments forfaitisés
            </legend>
			<?php
                        // parcour du tableau associatif $lesFraisForfait
				foreach ($lesFraisForfait as $unFrais)
				{
					$idFrais = $unFrais['idfrais'];
					$libelle = $unFrais['libelle'];
					$quantite = $unFrais['quantite'];
                                        $sommeFF += $quantite ;
			?>
					<p>
						<label for="idFrais"><?php echo $libelle ; ?></label>
						<input type="text" id="idFrais" name="lesFrais[<?php echo $idFrais ; ?>]" size="10" maxlength="5" value="<?php echo $quantite ; ?>" >
					</p>
			
			<?php
				}
			?>
			 
          </fieldset>
          <h3>TOTAL DES ELEMENTS FORFAITISES : <?php echo $sommeFF ; ?></h3>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" name="valid" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>     
    </form> 
    <!-- Affichage des informations liée aux élements fors forfaitisés -->
    <div class="corpsForm"> 
        <input type="hidden" name="idVis" value="<?php echo $idVisiteur ; ?>" />
           <input type="hidden" name="leMois" value="<?php echo $moisAng ; ?>" />
      <table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait</caption>
             <tr>
                <th class="date">Date</th>
				<th class="libelle">Libellé</th>  
                <th class="montant">Montant</th>  
                <th class="action"><?php espace() ;?></th>   
              
             </tr>
          
    <?php   
            if($ok = FALSE ) 
             {
                 ?> 
             <table><i><tr> Aucun frais hors forfait pour ce mois </tr></i></table>
             <?php } else {
                  foreach( $lesFraisHorsForfait as $unFraisHorsForfait) 
		     {
			$libelle = $unFraisHorsForfait['libelle'];
			$date = $unFraisHorsForfait['date'];
			$montant=$unFraisHorsForfait['montant'];
			$id = $unFraisHorsForfait['id'];
                        if (substr($libelle, 0 , 6) == "REFUSE") {
                            $sommeFHF += 0 ;
                        } else {
                           $sommeFHF +=  $montant ; 
                        }
                        
	     ?>
             
            <tr>
                <td> <?php echo $date ; ?></td>
                <td><?php echo $libelle ; ?></td>
                <td><?php echo $montant ; ?></td>
                <?php if(substr($libelle, 0 , 6) != "REFUSE"){ ?>
                <td><a href="index.php?uc=validerFraisFiche&action=supprimerFrais&idFrais=<?php echo $id ; ?>&idVis=<?php echo $idVisiteur ; ?>&moisAng=<?php echo $moisAng ; ?>" 
				onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Supprimer ce frais</a></td>
                 <?php } ?>                             
             </tr>

      <?php } 
         } ?>
      </table> 		 
        <h3>TOTAL DES FRAIS HORS FORFAITS : <?php echo $sommeFHF ; ?> </h3>  
        </div> <br />
            <form method="POST"  action="index.php?uc=validerFraisFiche&action=validerJustificatif"> 
                <div class="corpsForm">
                <input type="hidden" name="idVis" value="<?php echo $idVisiteur ; ?>" />
                <input type="hidden" name="leMois" value="<?php echo $moisAng  ; ?>" />
                <p>
                    <label for="nbJustificatif"> Nombre de justificatifs fournis :</label>
                    <input type="text" name="nbJustificatif" value="<?php echo $nbJustificatifs ; ?>" size="5" maxlength="5">
                </p>
                </div>
        <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p>
      </div>
    <br />
     </form>
     <form method="POST"  action="index.php?uc=validerFraisFiche&action=validerFiche">
        <div class="corpsForm">
            <input type="hidden" name="idVis" value="<?php echo $idVisiteur ; ?>" />
            <input type="hidden" name="leMois" value="<?php echo $moisAng ;  ?>" />
            <h3> Montant total à valider : <?php echo $sommeFF + $sommeFHF ; ?> </h3>
            <input type="hidden" name="montantValide" value="<?php echo $sommeFF + $sommeFHF ; ?>" />
        </div>
        <div class="piedForm">
         <p><input id="ok" type="submit" value="Valider cette fiche" size="40" /></p> 
        </div>
     </form>        
</div>
