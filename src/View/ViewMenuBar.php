	<div class="space">
		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="ViewIndex.php">ScrumManager</a>
				</div>
				<center>
				
					<div class="navbar-collapse collapse" id="navbar-main">
						<!-- Si l'utilisateur est connecté on lui propose de créer un nouveau projet ou de voir les projets dans lesquels il est inscrit -->
						<?php include '../Controler/ControlerAuth.php'; if(isConnected()){?>
						<ul class="nav navbar-nav">
							<li><a href="ViewCreateProject.php">Créer projet</a>
							</li>
							<li><a href="#">Voir projets</a>
							</li>
						</ul>
						<?php } ?>
						<!-- Si l'utilisateur n'est pas connecté, on affiche le formulaire d'authentification et un bouton menant à l'inscription -->
						<?php if(!isConnected()){?>
						<form class="navbar-form navbar-right" method="post" action="../Handler/Identification.php">
							<div class="form-group">
								<input type="text" class="form-control" name="login" placeholder="Nom de compte">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="password" placeholder="Mot de passe">
							</div>
							<button type="submit" class="btn btn-default">Se Connecter</button>
						</form>
						<form class="navbar-form navbar-right" method="post" action="ViewSignUp.php" > 
									<input class="btn btn-default" type="submit" name="submit" value="S'inscrire"/>
						</form>
							<!-- Si l'utilisateur est connecté on lui propose de ce déconnecter -->
						<?php } else{?>
						<form class="navbar-form navbar-right" method="post" action="../Handler/Deconnexion.php">
								Bonjour <?php echo $_SESSION['pseudo']?> 
								<input class="btn btn-default" type="submit" name="submit" value="Se déconnecter"/>
						</form>
						<?php } ?>
					</div>
				</center>
			</div>
		</div>
	</div>