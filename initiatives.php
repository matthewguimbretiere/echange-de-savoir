<?php 
include_once('cookieconnect.php');
require('./libs/bdd/bdd.php');

$titre="Partage d'intiatives"; //Nom de la page
$msg = "";
$msg2 = "";
/*----DEFINITION USER----*/
if(!empty($_SESSION['id'])) {
$requser = $bdd->prepare('SELECT * FROM membre WHERE id = ?');
$requser->execute(array($_SESSION['id']));
$userinfo = $requser->fetch();
}
/*--DEFINITION DATE--*/
$dateauj =  date("Y-m-d");
/*---------Recherche des intiatives------*/
$pdoListInit = $bdd->prepare('SELECT * FROM initiative WHERE dateInit >= ? ORDER BY dateInit ASC, heure ASC');
$executeIsOk = $pdoListInit->execute(array($dateauj));
$initListe = $pdoListInit->fetchAll();


/*---------Inscription de l'initiative-----*/
if(isset($_POST['valider'])){
	/*--DEFINITION TITRE--*/
	$titreInitiative = "";
	if ($_POST['titreInitiative'] == "autre") {
		if (!empty($_POST['titreInitiativeAutre'])) {
			$titreInitiative = htmlspecialchars($_POST['titreInitiative']);
		} else {
			$msg = "Veuillez rentrer un titre.";
		}
	} else {
		if ($_POST['titreInitiative']=="echecs") {
				$titreInitiative = "Initiation aux échecs";
			} elseif ($_POST['titreInitiative'] == "informatique") {
				$titreInitiative = "Initiation à l'informatique";
			} elseif ($_POST['titreInitiative'] == "theatre") {
				$titreInitiative = "Initiation au théâtre";
			} elseif ($_POST['titreInitiative'] == "cinema") {
				$titreInitiative = "Initiation au cinéma";
			} elseif ($_POST['titreInitiative'] == "peinture") {
				$titreInitiative = "Initiation à la peinture";
			} elseif ($_POST['titreInitiative'] == "sculpture") {
				$titreInitiative = "Initiation à la sculpture";
			} elseif ($_POST['titreInitiative'] == "musique") {
				$titreInitiative = "Initiation à la musique";
			} elseif ($_POST['titreInitiative'] == "football") {
				$titreInitiative = "Initiation au football";
			} elseif ($_POST['titreInitiative'] == "tennis") {
				$titreInitiative = "Initiation au tennis";
			} elseif ($_POST['titreInitiative'] == "rugby") {
				$titreInitiative = "Initiation au rugby";
			} elseif ($_POST['titreInitiative'] == "handball") {
				$titreInitiative = "Initiation au handball";
			} elseif ($_POST['titreInitiative'] == "basketball") {
				$titreInitiative = "Initiation au basketball";
			} elseif ($_POST['titreInitiative'] == "badminton") {
				$titreInitiative = "Initiation au badminton";
			} elseif ($_POST['titreInitiative'] == "tennis_table") {
				$titreInitiative = "Initiation au tennis de table";
			} elseif ($_POST['titreInitiative'] == "combat") {
				$titreInitiative = "Initiation aux sports de combat";
			} elseif ($_POST['titreInitiative'] == "escrime") {
				$titreInitiative = "Initiation à l'escrime";
			} elseif ($_POST['titreInitiative'] == "danse") {
				$titreInitiative = "Initiation au danse";
			}
	}
	

	/*--DEFINITION LIEU--*/
	if (!empty($_POST['lieuInitiative'])) {		
		$lieuInitiative = htmlspecialchars($_POST['lieuInitiative']);
	} else {		
		$lieuInitiative = "Lieu à venir.";
	}

	
	/*--INSCRIPTION--*/
	if (!empty($titreInitiative) AND !empty($_POST['descrInitiative']) AND !empty($_POST['coutInitiative']) AND !empty($_POST['dateInitiative']) AND !empty($_POST['heureInitiative']) AND !empty($_POST['minuteInitiative'])){	
		$descrInitiative = htmlspecialchars($_POST['descrInitiative']);
		$coutInitiative = htmlspecialchars($_POST['coutInitiative']);
		$dateInitiative = htmlspecialchars($_POST['dateInitiative']);
		$heureInitiative = htmlspecialchars($_POST['heureInitiative']);
		$minuteInitiative = htmlspecialchars($_POST['minuteInitiative']);
		$nom = $userinfo['prenom'].' '.$userinfo['nom'];
		if ($_POST['titreInitiative']=="echecs") {
				$img = "echec_initiatives.jpg";
			} elseif ($_POST['titreInitiative'] == "informatique") {
				$img = "informatique_echange_de_savoir.jpg";
			} elseif ($_POST['titreInitiative'] == "theatre") {
				$img = "theatre_echange_de_savoir.jpg";
			} elseif ($_POST['titreInitiative'] == "cinema") {
				$img = "cinema_echange_de_savoir.jpg";
			} elseif ($_POST['titreInitiative'] == "peinture") {
				$img = "peinture_echange_de_savoir.jpg";
			} elseif ($_POST['titreInitiative'] == "sculpture") {
				$img = "sculpture_echange_de_savoir.jpg";
			} elseif ($_POST['titreInitiative'] == "musique") {
				$img = "musique_echange_de_savoir.jpg";
			} elseif ($_POST['titreInitiative'] == "football") {
				$img = "football_echange_de_savoir.jpg";
			} elseif ($_POST['titreInitiative'] == "tennis") {
				$img = "tennis_echange_de_savoir.jpg";
			} elseif ($_POST['titreInitiative'] == "rugby") {
				$img = "rugby_echange_de_savoir.jpg";
			} elseif ($_POST['titreInitiative'] == "handball") {
				$img = "handball_echange_de_savoir.jpg";
			} elseif ($_POST['titreInitiative'] == "basketball") {
				$img = "basketball_echange_de_savoir.jpg";
			} elseif ($_POST['titreInitiative'] == "badminton") {
				$img = "badminton_echange_de_savoir.jpg";
			} elseif ($_POST['titreInitiative'] == "tennis_table") {
				$img = "ping_pong_echange_de_savoir.jpg";
			} elseif ($_POST['titreInitiative'] == "combat") {
				$img = "combat_echange_de_savoir.jpg";
			} elseif ($_POST['titreInitiative'] == "escrime") {
				$img = "escrime_echange_de_savoir.jpg";
			} elseif ($_POST['titreInitiative'] == "danse") {
				$img = "danse_echange_de_savoir.jpg";
			}
		/*--DEFINITION IMAGE--*/
			if($heureInitiative < 24) {
				if ($minuteInitiative < 60) {				
					$heure = $heureInitiative." : ".$minuteInitiative;
					/*----------VERIFICATION INSCRIPTION--------*/		

					$reqINSCRIPTION = $bdd->prepare("SELECT * FROM initiative WHERE auteur = ? AND dateInit = ? AND heure = ?");
				    $reqINSCRIPTION->execute(array($nom, $dateInitiative, $heure));
				    $inscriptionexist = $reqINSCRIPTION->rowCount();
				    if ($inscriptionexist ==0 ) {
				  		$insertInit = $bdd->prepare('INSERT INTO initiative(auteur,description,cout,titre,dateInit,lieu,heure,image) VALUES(?,?,?,?,?,?,?,?) ');
						$insertInit->execute(array($nom,$descrInitiative,$coutInitiative,$titreInitiative,$dateInitiative,$lieuInitiative,$heure,$img));
						$msg = "L'initiative est bien rentrée.";
				    }						
				} else {
					$msg = "Veuillez rentrer une minute inférieure à 60.";
				}
			} else {
				$msg = "Veuillez rentrer une heure inférieure à 24.";
			}
		if (!empty($_FILES)) {
				$img_name = $_FILES['imageInitiative']['name'];
				$img_extension = strrchr($img_name, ".");
				$image_tmp_name = $_FILES['imageInitiative']['tmp_name'];
				$img_dest = './media/init/'.$img_name;
				$extensions_autorisees_img = array('.jpg', '.jpeg', '.JPG', '.JPEG', '.webp','.png', '.PNG');
			if (in_array($img_extension, $extensions_autorisees_img)) {
				if (move_uploaded_file($image_tmp_name, $img_dest)) {
					$newInit = $bdd->prepare("UPDATE initiative SET image = ? WHERE titre = ? AND auteur = ? AND description = ?");
					$newInit->execute(array($img_name,$titreInitiative,$nom,$descrInitiative));
					} else {
					$msg = "Une erreur a été détectée";
				}
			} else {
				$msg = "Seul les fichiers jpg, jpeg, webp et png sont autorisés";
			}

		} 					
	}
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
	<!-------AFFICHAGE DES INITIATIVES--------->
	<section id="listIni" class="sectiongeneral">
		<h1>Liste des initiatives</h1>
		<hr>
		<?php foreach ($initListe as $initListes) { ?> <!--Affichage de la dernière intiative-->
		<?php 
			if(!empty($_SESSION['id'])){
				/*----------VERIFICATION PARTICIPATION--------*/
				$reqParticipation = $bdd->prepare("SELECT * FROM participation WHERE id_membre = ? AND id_init = ?");
	            $reqParticipation->execute(array($_SESSION['id'], $initListes['id_init']));
	            $participationexist = $reqParticipation->rowCount();

	            /*---------Participation à une initiative------*/
				if (isset($_POST['participer'])) {
					if($participationexist == 0){
						$insertParticipation = $bdd->prepare('INSERT INTO participation(id_membre,id_init) VALUES(?,?)');
						$insertParticipation->execute(array($_SESSION['id'],$initListes['id_init']));
						$msg2 = "La participation est bien prise en compte.";
					}
				}
			}
		?>
			<article class="article">
				<div>
					<h2><?= $initListes['titre'] ?>, <b><?= $initListes['cout'] ?>€/heures</b></h2>
					<h6 class="messageSup">Par <b><?= $initListes['auteur'] ?></b>,<br/>
					Prochain atelier: <b><?= $initListes['dateInit'] ?></b> à <b><?= $initListes['heure'] ?></b>, <?= $initListes['lieu'] ?>.</h6><br/>
					<p><?= $initListes['description'] ?></p>
					<!--VERIFICATION PARTICIPATION-->
					<?php if(!empty($_SESSION['id'])) { ?>
						<?php if($initListes['auteur'] != $userinfo['prenom'].' '.$userinfo['nom']) {
							if($participationexist == 0) { ?>
								<form method="post">
									<input type="submit" name="participer" class="boutons" value="Participer">
								</form>
							<?php } else { 
								echo '<p style="color:red;">Vous participer déjà à cette initiative</p>';
							} ?>
							<?php
								if(isset($msg2))	{
									echo '<p style="color:red;">'.$msg2.'</p>';
								}
							?>
						<?php } else { ?>
							<?php 
								/*--SUPPRESSION--*/
								if (isset($_POST['supprimer'])) {
									$delInit = $bdd->prepare('DELETE FROM initiative WHERE id_init = ?');
									$delInit->execute(array($initListes['id_init']));
								}
							?>
							<form method="post">
								<input type="submit" name="supprimer" class="boutons" value="Supprimer">
							</form>
						<?php } ?>
					<?php } else { ?> 
						<a href="./connexion.php" class="boutons">Se connecter</a>
					<?php } ?>
				</div>
				<?php if(!empty($initListes['image'])) { ?>
					<img src="./media/init/<?= $initListes['image'] ?>" alt="<?= $initListes['titre'] ?> - Echange de savoir">
				<?php } ?>
			</article>
		<?php } ?>
	</section>
	<!-------FORMULAIRE DES INITIATIVES--------->
	<section id="formIni" class="sectiongeneral">
		<h1>Proposez votre initiative</h1>
		<hr>
		<?php if(!empty($_SESSION['id'])) { ?><!--Vérification si l'utilisateur est connecté-->
		<p>Pour proposer une activité veuillez remplir le formulaire ci-dessous. 
Faîtes attention à la description de votre activité, faites en sorte que tout le monde comprenne cette dernière.</p>
		<form id="formulaireInit" class="formulaire" method="post" enctype="multipart/form-data">
			<!--------TITRE------>
			<label for="titreInitiative">Titre de l'initiative:</label>
			<select name="titreInitiative" id="titreInitiative" required="">
				<!--Loisirs-->
				<option value="echecs">Initiation aux echecs</option>
				<option value="informatique">Initiation à l'informatique</option>
				<option value="theatre">Initiation au théâtre</option>
				<option value="cinema">Initiation au cinéma</option>
				<option value="peinture">Initiation à la peinture</option>
				<option value="sculpture">Initiation à la sculpture</option>
				<option value="musique">Initiation à la musique</option>
				<!--Sport-->
				<option value="football">Initiation au football</option>
				<option value="tennis">Initiation au tennis</option>
				<option value="rugby">Initiation au rugby</option>
				<option value="handball">Initiation au handball</option>
				<option value="basketball">Initiation au basketball</option>
				<option value="badminton">Initiation au badminton</option>
				<option value="tennis_table">Initiation au tennis de table</option>
				<option value="combat">Initiation aux sports de combat</option>
				<option value="escrime">Initiation à l'escrime</option>
				<option value="danse">Initiation à la danse</option>
				<!--Autre-->
				<option value="autre">Autre</option>
			</select>
			<input type="text" name="titreInitiativeAutre" id="titreInitiativeAutre" hidden="hidden" placeholder="Titre">
			<!--------DESCRIPTION------>
			<label for="descrInitiative">Description de l'initiative:</label>
			<textarea name="descrInitiative" id="descrInitiative" placeholder="Description de l'initiative" required=""></textarea>
			<!-------Coût----->
			<label for="coutInitiative">Coût de l'initiative:</label>
			<div><input type="number" name="coutInitiative" id="coutInitiative" required=""> €</div>
			<!-------Date----->
			<label for="dateInitiative">Date de l'initiative:</label>
			<input type="date" name="dateInitiative" id="dateInitiative" required="">
			<!-------Heure----->
			<label for="heureInitiative">Heure de l'initiative:</label>
			<div><input type="number" name="heureInitiative" id="heureInitiative" placeholder="00" required="">:
			<input type="number" name="minuteInitiative" id="minuteInitiative" placeholder="00" required="" value="00"></div>
			<!-------Lieu----->
			<label for="lieuInitiative">Lieu de l'initiative:</label>
			<input type="text" name="lieuInitiative" id="lieuInitiative">
			<!-------Image----->
			<label for="imageInitiative">Image de l'initiative:</label>
			<input type="file" name="imageInitiative" id="imageInitiative">
			<!-------Validation-->
			<input type="submit" name="valider" value="Valider" class="boutons">
			<!--Affichage d'un message d'erreur-->
			<?php
				if(isset($msg))	{
					echo '<p style="color:red;">'.$msg.'</p>';
				}
			?>
			<p>Après l’envoi du formulaire, nous allons étudier votre activité et essayer de vous fournir un local pour que vous puissiez l’organiser.</p>
		</form>
		<?php } else { ?>
			<h2>Veuillez vous connecter pour partager une initiative.</h2>
			<a href="./connexion.php" class="boutons">Se connecter</a>
		<?php } ?>

	</section>
	
	<footer><?php require('./libs/footer.php') ?></footer> <!--Partie Footer-->
</body>
</html>
