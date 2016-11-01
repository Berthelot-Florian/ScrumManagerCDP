<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Titre</title>
    </head>

    <body>
		<?php include 'Controler/ControlerBdd.php';?>
		<form method="post" action="Identification.php">
			<fieldset><legend>Login : </legend><input type="text" name="login"/></fieldset>
			<fieldset><legend>Mot de passe : </legend><input type="text" name="password"/></fieldset>
			<input type="submit" name="submit" value="Se connecter"/>
		</form> 
		<form method="post" action="Inscription.php"><input type="submit" name="submit" value="S'inscrire"/></form>
		<?php } ?>
		
		<?php if(isConnected()){?>
		<?php echo "Bonjour "+$_SESSION['login'] ;?>
		<form method="post" action="Deconnexion.php"><input type="submit" name="submit" value="Se déconnecter"/></form>
		<?php } ?>
		

    </body>
</html>



