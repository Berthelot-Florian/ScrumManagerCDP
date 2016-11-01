<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Titre</title>
		<link rel="stylesheet" href="../css/bootstrap.css"> 
		<link rel="stylesheet" href="../css/index.css"> 
    </head>

    <body>
		<?php include 'ViewMenuBar.php' ?>
		
		<center>
			<div class="littlespace">
				<form method="post" action="../Handler/SignUp.php">
					<fieldset>
							<h2>Nom de compte</h2><input type="text" name="login"/>
							<h2>Mot de passe</h2><input type="text" name="password"/>
							<h2>Pseudo</h2><input type="text" name="pseudo"/>
							<h2>Email</h2><input type="text" name="email"/>
					</fieldset>

			</div>
					<input class="btn btn-default" type="submit" name="submit" value="S'inscrire"/>
				</form> 
		</center>
    </body>
</html>

