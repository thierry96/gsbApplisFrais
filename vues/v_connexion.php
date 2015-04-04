<?php include_once("include/fct.inc.php"); ?>
<div id="contenu">   
      <h2>Identification utilisateur</h2>

<?php retourLigne(2) ?>
<form method="POST" action="index.php?uc=connexion&action=valideConnexion">
   
    <div class="corpsForm">
      <p>
       <label for="nom">Login*</label> <?php espace(10) ; ?> 
       <input id="login" type="text" name="login"  size="30" maxlength="45">
      </p>
       <p>
	<label for="mdp">Mot de passe* </label> <?php espace(10) ; ?>
	<input id="mdp"  type="password"  name="mdp" size="30" maxlength="45">
      </p>
      </div>
    <div class="piedForm">
        <p>
         <input type="submit" value="Valider" name="valider">
         <input type="reset" value="Annuler" name="annuler"> <?php espace() ; ?>
      </p>
    </div>
</form>

</div>