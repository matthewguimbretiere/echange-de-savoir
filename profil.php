<?php
include_once('cookieconnect.php');
require('./libs/bdd/bdd.php');

$titre="Accueil"; //Nom de la page
$msg = "";
if(isset($_GET['section'])){
	$section = htmlspecialchars($_GET['section']);
} else {
	$section = "";
}

/*--VERIFICATION USER CONNECTER--*/
if(!empty($_SESSION['id'])) {
	$requser = $bdd->prepare('SELECT * FROM membre WHERE id = ?');
	$requser->execute(array($_SESSION['id']));
	$userinfo = $requser->fetch();

	/*-----MODIFICATION------*/
	if (isset($_POST['formmodif'])) {
		if (!empty($_POST['modifPseudo']) AND !empty($_POST['modifPrenom']) AND !empty($_POST['modifNom']) AND !empty($_POST['modifMail']) AND !empty($_POST['modifTel'])) {
			$modifPseudo = htmlspecialchars($_POST['modifPseudo']);
			$modifPrenom = htmlspecialchars($_POST['modifPrenom']);
			$modifNom = htmlspecialchars($_POST['modifNom']);
			$modifMail = htmlspecialchars($_POST['modifMail']);
			$modifTel = htmlspecialchars($_POST['modifTel']);

					/*--DEFINITION ADRESSE--*/
			if (!empty($_POST['modifAdr'])) {
				$modifAdr = htmlspecialchars($_POST['modifAdr']);
			} else {
				$modifAdr = "";
			}
			/*--DEFINITION VILLE--*/
			if (!empty($_POST['modifVille'])) {
				$modifVille = htmlspecialchars($_POST['modifVille']);
			} else {
				$modifVille = "";
			}
			/*--DEFINITION CP--*/
			if (!empty($_POST['modifCp'])) {
				$modifCp = htmlspecialchars($_POST['modifCp']);
			} else {
				$modifCp = "";
			}
			/*--DEFINITION PROFESSION--*/
			if (!empty($_POST['modifProf'])) {
				$modifProf = htmlspecialchars($_POST['modifProf']);
			} else {
				$modifProf = "";
			}


			$pseudoModifTaille = strlen($modifPseudo);
			if($pseudoModifTaille<=255){
				$reqpseudo = $bdd->prepare("SELECT * FROM membre WHERE pseudo = ? AND id != ?");
				$reqpseudo->execute(array($modifPseudo,$_SESSION['id']));
				$pseudoexist = $reqpseudo->rowCount();
				if($pseudoexist ==0){
					if(filter_var($modifMail, FILTER_VALIDATE_EMAIL)) {
						$reqmail = $bdd->prepare("SELECT * FROM membre WHERE mail = ? AND id != ?");
	               		$reqmail->execute(array($modifMail,$_SESSION['id']));
	               		$mailexist = $reqmail->rowCount();
	               		if($mailexist == 0) {
	               			if( is_numeric($modifTel) && strlen($modifTel) == 10){
								$newInfos = $bdd->prepare("UPDATE membre SET pseudo = ?,prenom = ?,nom = ?,mail = ?,tel = ?,adresse = ?,ville = ?,cp = ?, profession = ? WHERE id = ?");
							    $newInfos->execute(array($modifPseudo,$modifPrenom,$modifNom,$modifMail,$modifTel,$modifAdr,$modifVille,$modifCp,$modifProf, $_SESSION['id']));
							    header('Location: ./profil.php');
							} else {
								$msg = "Mauvais numéro de téléphone.";
							}
						} else {
               				$msg = "Adresse mail déjà utilisée.";
               			}
					} else {
						$msg = "Votre adresse mail n'est pas valide.";
					}
			    } else {
					$msg = "Un compte utilise déjà ce pseudo.";
				}
		    } else {
				$msg = "Votre pseudo ne doit pas dépasser 255 caractères.";
			}
		} else {
			$msg = "Veuillez remplir tout les champs.";
		}
	}
	/*----MODIFICATION MOT DE PASSE---*/
	if (isset($_POST['formmdp']) AND !empty($_POST['newmdp']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])){
		$mdp1 = sha1($_POST['newmdp']);
		$mdp2 = sha1($_POST['newmdp2']);

		if ($mdp1 == $mdp2) {
			$insertmdp = $bdd->prepare("UPDATE membre SET mdp = ? WHERE id = ?");
        		$insertmdp->execute(array($mdp1, $_SESSION['id']));
       		header("Location: profil.php");
      	} else {
        	$msg = "Vos deux mdp ne correspondent pas.";
      	}
   	} else {
   		$smg = "Veuillez remplir tout les champs.";
   	}    
?>
<!DOCTYPE html>
<html>
<head>
	<?php require('./libs/head.php') ?> <!--Partie Head-->
	<title>Échange de savoirs - <?= $titre ?> - Une diversité générationnelle et culturelle.</title> <!--Titre-->
</head>
<body>
	<header><?php require('./libs/header.php') ?></header> <!--Partie Header-->
	<!------PROFIL-------->
	<?php if(empty($section)) { ?>
	<section id="profil" class="sectiongeneral formulaire">
		<h1>Vos informations:</h1>
		<div><label>Pseudo: </label>
		<h5><?= $userinfo['pseudo'] ?></h5></div>
		<div><label>Prénom: </label>
		<h5><?= $userinfo['prenom'] ?></h5></div>
		<div><label>Nom: </label>
		<h5><?= $userinfo['nom'] ?></h5></div>
		<div><label>Adresse mail: </label>
		<h5><?= $userinfo['mail'] ?></h5></div>
		<div><label>Téléphone: </label>
		<h5>0<?= $userinfo['tel'] ?></h5></div>
		<div><label>Adresse: </label>
		<h5><?= $userinfo['adresse'] ?></h5></div>
		<div><label>Ville: </label>
		<h5><?= $userinfo['ville'] ?></h5></div>
		<div><label>Code postal: </label>
		<h5><?= $userinfo['cp'] ?></h5></div>
		<div><label>Profession: </label>
		<h5><?= $userinfo['profession'] ?></h5></div>
		<div>
			<a href="./profil.php?section=modification" class="boutons">Modifiez votre profil</a>
			<a href="./profil.php?section=motdepasse" class="boutons">Modifiez votre mot de passe</a>
			<a href="./deconnexion.php" class="boutons">Déconnexion</a>
		</div>
	</section>
	<?php } elseif($section == "modification") { ?>
		<section id="modifProfil" class="formulaire">
			<form method="post">
				<h1>Vos informations:</h1>
				<label for="modifPseudo">Pseudo: </label>
				<input type="text" name="modifPseudo" id="modifPseudo" value="<?= $userinfo['pseudo'] ?>">
				<label for="modifPrenom">Prénom: </label>
				<input type="text" name="modifPrenom" id="modifPrenom" value="<?= $userinfo['prenom'] ?>">
				<label for="modifNom">Nom: </label>
				<input type="text" name="modifNom" id="modifNom" value="<?= $userinfo['nom'] ?>">
				<label for="modifMail">Adresse mail: </label>
				<input type="email" name="modifMail" id="modifMail" value="<?= $userinfo['mail'] ?>">
				<label for="modifTel">Téléphone: </label>
				<input type="text" name="modifTel" id="modifTel" value="0<?= $userinfo['tel'] ?>">
				<label for="modifAdr">Adresse: </label>
				<input type="text" name="modifAdr" id="modifAdr" value="<?= $userinfo['adresse'] ?>">
				<label for="modifVille">Ville: </label>
				<input type="text" name="modifVille" id="modifVille" value="<?= $userinfo['ville'] ?>">
				<label for="modifCp">Code postal: </label>
				<input type="number" name="modifCp" id="modifCp" value="<?= $userinfo['cp'] ?>">
				<label for="modifProf">Profession: </label>
				<input type="text" name="modifProf" id="modifProf" value="<?= $userinfo['profession'] ?>">
				<input type="submit" name="formmodif" id="formmodif" class="boutons">
				<!--Affichage d'un message d'erreur-->
				<?php
					if(isset($msg))	{
						echo '<p style="color:red; font-family:Roboto, sans-serif;">'.$msg.'</p>';
					}
				?>
				<div>
					<a href="./profil.php" class="boutons">Profil</a>
					<a href="./profil.php?section=motdepasse" class="boutons">Modifiez votre mot de passe</a>
					<a href="./deconnexion.php" class="boutons">Déconnexion</a>
				</div>

			</form>
		</section>
	<?php } elseif($section=="motdepasse") {?>
		<section id="modifMdp" class="formulaire">
			<h1>Modifiez votre mot de passe</h1>
			<form method="post">
				<label for="newmdp">Nouveau mot de passe</label>
				<input type="password" name="newmdp" id="newmdp">
				<label for="newmdp2">Confirmation du mot de passe</label>
				<input type="password" name="newmdp2" id="newmdp2">
				<input type="submit" name="formmdp" id="formmdp" class="boutons">
				<!--Affichage d'un message d'erreur-->
					<?php
						if(isset($msg))	{
							echo '<p style="color:red; font-family:Roboto, sans-serif;">'.$msg.'</p>';
						}
					?>
				<div>
					<a href="./profil.php" class="boutons">Profil</a>
					<a href="./profil.php?section=modification" class="boutons">Modifiez votre profil</a>
					<a href="./deconnexion.php" class="boutons">Déconnexion</a>
				</div>
			</form>
		</section>
	<?php } ?>
	
	<footer><?php require('./libs/footer.php') ?></footer> <!--Partie Footer-->
</body>
</html>
<?php } ?>