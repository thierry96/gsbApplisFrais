
<div id="contenu">
    <h2> Valider les fiches de frais  </h2>
    <h3>Visiteur et mois à sélectionner </h3>
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
                        if ($nom." ".$prenom === $leVisiteur['nom']." ".$leVisiteur['prenom']) {                                                      
                        ?>
                        <option selected value="<?php echo  $id ;  ?>"><?php echo  $nom." ".$prenom ;  ?> </option>
                        <?php
                         } else {
                        ?> 
                         <option  value="<?php echo  $id ;  ?>"><?php echo  $nom." ".$prenom ;  ?> </option>
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
                  if($lesMois != NULL) { // Boucle pour le parcour du tableau associatif $lesMois
			foreach ($lesMois as $unMois)
			{
                            //récupération du mois au format aa/mmmm
			    $mois = $unMois['numMois']."/".$unMois['numAnnee'];
                            $numAnnee =  $unMois['numAnnee'];
                            $numMois =  $unMois['numMois'];
                            // condition pour savoir si le mois à la position t est égale au mois choisi
				if ($mois == $moisASelectionner) {
				?>
				<option selected value="<?php echo $mois ;  ?>"><?php echo  $numMois."/".$numAnnee ;  ?> </option>
				<?php 
				} else { ?>
				<option value="<?php echo $mois ; ?>"><?php echo  $numMois."/".$numAnnee ;  ?> </option>
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
       <input id="ok" type="submit" value="Valider" size="20" />
         </p> 
      </div>
    </form>
        
</div>

