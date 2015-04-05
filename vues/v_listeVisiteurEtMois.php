
<div id="contenu">
    <h2> Valider les fiches de frais  </h2>
    <h3>Visiteur et mois à sélectionner </h3>
    <form action="index.php?uc=validerFraisFiche&action=validerFrais" method="POST">
        <div class="corpsForm">
            <p>
            <label for="lstVisiteur">Visiteur :</label>
           
            <select name="lstVisiteur" >
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
                        <option selected value="<?php echo  $id; ?>"><?php echo  $nom." ".$prenom ;?> </option>
                        <?php
                         } else {
                        ?> 
                         <option  value="<?php echo  $id ;?>"><?php echo  $nom." ".$prenom; ?> </option>
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
                  if($lesMois != NULL)
                  {
			foreach ($lesMois as $unMois)
			{
			    $mois = $unMois['numMois']."/".$unMois['numAnnee'];
				$numAnnee =  $unMois['numAnnee'];
				$numMois =  $unMois['numMois'];
				if ($mois === $moisASelectionner) {
				?>
				<option selected value="<?php echo $mois ;  ?>"><?php echo  $numMois."/".$numAnnee ;  ?> </option>
				<?php 
				} else { ?>
				<option value="<?php echo $mois ;  ?>"><?php echo  $numMois."/".$numAnnee ;  ?> </option>
				<?php 
				}	
			}
                  } 

		   ?>         
        </select>
            </p>          
        </div>
        <div class="piedForm">
         <p>
       <input id="ok" type="submit" value="Valider" size="20" name="valid"/>
         </p> 
      </div>
    </form>
        
</div>

