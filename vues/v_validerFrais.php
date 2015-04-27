
   <h3>Détail de la fiche de frais : <?php echo $leVisiteur['nom']." ".$leVisiteur['prenom'] ;  ?> - 
   <?php echo $moisASelectionner ;  ?> </h3>
   
    Etat: <?php echo $lesInfosFicheFrais['libEtat']; ?> 
    depuis le <?php echo dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']) ; ?> <br />
    Montant validé : <?php echo $lesInfosFicheFrais['montantValide'] ; ?>
    <!-- Affichage des informations liées aux élements forfaitisés -->
    <form method="POST"  action="index.php?uc=validerFraisFiche&action=validerMajFraisForfait">
      <div class="corpsForm">
          <input type="hidden" name="idVis" value="<?php echo $idVisiteur ; ?>" />
           <input type="hidden" name="leMois" value="<?php echo $moisAng ;  ?>" />
          <fieldset>
            <legend>Eléments forfaitisés
            </legend>
			<?php
                        if($lesInfosFicheFrais['idEtat'] === 'CR'){
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
                        } else { ?>
                           <table class="listeLegere">
                            <tr>
                        <?php
                        foreach ( $lesFraisForfait as $unFraisForfait ) {
                            $libelle = $unFraisForfait['libelle'];
                        ?>	
			<th> <?php echo $libelle ; ?></th>
                        <?php
                            }
                        ?>
                        </tr>
                        <tr>
                        <?php
                            foreach (  $lesFraisForfait as $unFraisForfait  ) {
				$quantite = $unFraisForfait['quantite'];
                                $sommeFF += $quantite ;
                        ?>
                        <td class="qteForfait"><?php echo $quantite ; ?> </td>
                        <?php
                            }
                        ?>
                        </tr>
                        </table> 
                       <?php }
			?>
			 
          </fieldset>
          <h3>TOTAL DES ELEMENTS FORFAITISES : <?php echo $sommeFF ; ?></h3>
      </div>
        <?php if($lesInfosFicheFrais['idEtat'] === 'CR'){ ?>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" name="valid" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div> 
        <?php } ?>
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
                <?php if($lesInfosFicheFrais['idEtat'] === 'CR'){ ?>
                <th class="action"><?php espace() ;?></th><?php } ?>   
              
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
                <?php if((substr($libelle, 0 , 6) !== "REFUSE")&& ($lesInfosFicheFrais['idEtat'] === 'CR')){ ?>
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
                    
                    <?php if($lesInfosFicheFrais['idEtat'] === 'CR') { ?>
                    <label for="nbJustificatif"> Nombre de justificatifs fournis :</label>
                    <input type="text" name="nbJustificatif" value="<?php echo $nbJustificatifs ; ?>" size="5" maxlength="5">
                 <h1><?php } else { 
                    espace(2) ?> Nombre de justificatifs fournis : <?php
                        echo $nbJustificatifs ;
                    }
                    ?></h1>
                    
                </p>
                </div>
                <?php if($lesInfosFicheFrais['idEtat'] === 'CR'){ ?>
        <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p>
      </div>
                <?php } ?>
    <br />
     </form>
      <?php if($lesInfosFicheFrais['idEtat'] === 'CR') { ?>  
     <form method="POST"  action="index.php?uc=validerFraisFiche&action=validerFiche">
        <div class="corpsForm">
            <input type="hidden" name="idVis" value="<?php echo $idVisiteur ; ?>" />
            <input type="hidden" name="leMois" value="<?php echo $moisAng ;  ?>" />
             <p><h3><label for="montantValide"> Montant total à valider :</label> </h3>            
            <input type="text" name="montantValide" value="<?php echo $sommeFF + $sommeFHF ; ?>" size="5" maxlength="5"/> </p>
        </div>
        <div class="piedForm">
         <p><input id="ok" type="submit" value="Valider cette fiche" size="40" /></p> 
        </div>
       <?php } ?>  
     </form>        
</div>
