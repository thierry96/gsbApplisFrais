
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
                        if ($nom." ".$prenom == $leVisiteur)
                            {                                                      
                        ?>
                        <option selected value="<?php echo  $nom." ".$prenom ?>"><?php echo  $nom." ".$prenom ?> </option>
                        <?php
                         }else {
                        ?> 
                         <option  value="<?php echo  $nom." ".$prenom ?>"><?php echo  $nom." ".$prenom ?> </option>
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
    </form>
   <h3>Fiche de frais de <?php echo $leVisiteur ?>, du mois de <?php echo $moisASelectionner ?>: </h3>
   <div class="corpsForm">
    Etat:
   </div>    
</div>

