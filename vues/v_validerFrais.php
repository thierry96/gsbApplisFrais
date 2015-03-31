
<div id="contenu">
    <h2> Valider les fiches de frais  </h2>
    <h3>Visiteur et mois à sélectionner</h3>
    <form action="index.php?uc=validerFraisFiche&action=validerFrais" method="POST">
        <div class="corpsForm">
            <p>
            <label for="lstVisiteur">Visiteur :</label>
            <select name="lstVisiteur">
                <?php 
                    foreach ($lesVisiteurs as $unVisiteur){
                        $nom = $unVisiteur['nom'];
                        $prenom = $unVisiteur['prenom'];
                        $id = $unVisiteur['id'];
                        if ($nom." ".$prenom == $leVisiteur['nom']." ".$leVisiteur['prenom'])
                            {                                                      
                        ?>
                        <option selected value="<?php echo  $id ?>"><?php echo  $nom." ".$prenom ?> </option>
                        <?php
                         }else {
                        ?> 
                         <option  value="<?php echo  $id ?>"><?php echo  $nom." ".$prenom ?> </option>
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
			foreach ($lesMois as $unMois)
			{
			    $mois = $unMois['numMois']."/".$unMois['numAnnee'];
				$numAnnee =  $unMois['numAnnee'];
				$numMois =  $unMois['numMois'];
				if($mois == $moisASelectionner){
				?>
				<option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
				}
				else{ ?>
				<option value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
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
   <h3>Détail de la fiche de frais : <?php echo $leVisiteur['nom']." ".$leVisiteur['prenom'] ?> - <?php echo $moisASelectionner ?>: </h3>
   
    Etat: <?php echo $infoVisiteur['libEtat']; ?> depuis le <?php echo dateAnglaisVersFrancais($infoVisiteur['dateModif']) ; ?> <br />
    Montant validé : <?php echo $infoVisiteur['montantValide'] ; ?>
  
    <form method="POST"  action="index.php?uc=validerFraisFiche&action=validerMajFraisForfait">
      <div class="corpsForm">
          
          <fieldset>
            <legend>Eléments forfaitisés
            </legend>
			<?php
                       
				foreach ($lesFraisForfait as $unFrais)
				{
					$idFrais = $unFrais['idfrais'];
					$libelle = $unFrais['libelle'];
					$quantite = $unFrais['quantite'];
                                        $sommeFF += $quantite ;
			?>
					<p>
						<label for="idFrais"><?php echo $libelle ?></label>
						<input type="text" id="idFrais" name="lesFrais[<?php echo $idFrais?>]" size="10" maxlength="5" value="<?php echo $quantite?>" >
					</p>
			
			<?php
				}
			?>
			 
          </fieldset>
          <h3>TOTAL DES ELEMENTS FORFAITISES : <?php echo $sommeFF ; ?></h3>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>     
    </form> 
    <div class="corpsForm">
      <table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait
       </caption>
             <tr>
                <th class="date">Date</th>
				<th class="libelle">Libellé</th>  
                <th class="montant">Montant</th>  
                <th class="action">&nbsp;</th>              
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
                        $sommeFHF +=  $montant ;
	     ?>
             
            <tr>
                <td> <?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
 
                <td><a href="index.php?uc=gererFrais&action=supprimerFrais&idFrais=<?php echo $id ?>" 
				onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Supprimer ce frais</a></td>
             </tr>

      <?php } 
            
       } ?></table> 		 
        <h3>TOTAL DES FRAIS HORS FORFAITS : <?php echo $sommeFHF ; ?> </h3>  
    </div> <br />

    <div class="corpsForm">
        <p>
            <label for="nbJustificatif"> Nombre de justificatifs fournis :</label>
            <input type="text" name="nbJustificatif" value="<?php echo $nbJustificatifs ;?>" size="5" maxlength="5">
        </p>
    </div>
        <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p>
      </div>
    <br />
    <div class="corpsForm">
            <h3> Montant total à valider : <?php echo $infoVisiteur['montantValide'] ; ?> </h3>
    </div>
    <div class="piedForm">
         <p><input id="ok" type="submit" value="Valider cette fiche" size="40" /></p> 
    </div>
    </form>
   
</div>
