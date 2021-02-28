<?php 
include_once('cookieconnect.php');
require('./libs/bdd/bdd.php');

$titre="Actualités"; //Nom de la page
$msg = "";
$msg2 = "";
$totalInit = 0;
/*----DEFINITION USER----*/
if(!empty($_SESSION['id'])) {
$requser = $bdd->prepare('SELECT * FROM membre WHERE id = ?');
$requser->execute(array($_SESSION['id']));
$userinfo = $requser->fetch();
}
/*---------Recherche des actualités------*/
$pdoListActu = $bdd->prepare('SELECT * FROM actualite ORDER BY date_actu DESC');
$executeIsOk = $pdoListActu->execute();
$actuListe = $pdoListActu->fetchAll();


/*---------Inscription de l'actualité-----*/
if(isset($_POST['valider'])){
	
	/*--DEFINITION IMAGE--*/
	if (!empty($_FILES)) {
		$img_name = $_FILES['imageActu']['name'];
		$img_extension = strrchr($img_name, ".");
		$image_tmp_name = $_FILES['imageActu']['tmp_name'];
		$img_dest = './media/actus/'.$img_name;
		$extensions_autorisees_img = array('.jpg', '.jpeg', '.JPG', '.JPEG', '.webp','.png', '.PNG');
	}

	/*--INSCRIPTION--*/
	if (!empty($_POST['titreActu']) AND !empty($_POST['descrActu'])){		
		/*--DEFINITION DESCRIPTION--*/
		$descrActu = htmlspecialchars($_POST['descrActu']);
		/*--DEFINITION TITRE--*/
		$titreActu = htmlspecialchars($_POST['titreActu']);
		/*--DEFINITION DATE--*/
		$dateauj =  date("d-m-Y");
		/*--DEFINTION AUTEUR---*/
		$nom = $userinfo['prenom'].' '.$userinfo['nom'];
		
		/*--DEFINITION IMAGE--*/
		if (!empty($_FILES)) {
			$img = $img_name;
		} else {
			$img = "";
		}

		if (in_array($img_extension, $extensions_autorisees_img)) {
			if (move_uploaded_file($image_tmp_name, $img_dest)) {
				/*----------VERIFICATION INSCRIPTION--------*/		
				$reqINSCRIPTION = $bdd->prepare("SELECT * FROM actualite WHERE auteur = ? AND titre = ? AND date_actu = ?");
				$reqINSCRIPTION->execute(array($nom, $titreActu, $dateauj));
				$inscriptionexist = $reqINSCRIPTION->rowCount();

				if ($inscriptionexist ==0 ) {
					$insertActu = $bdd->prepare('INSERT INTO actualite(titre,auteur,date_actu,description,image) VALUES(?,?,?,?,?) ');
					$insertActu->execute(array($titreActu,$nom,$dateauj,$descrActu,$img));	
					$msg = "Acutialité bien rentrée.";	
				}
			} else {
				$msg = "Une erreur a été détectée";
			}
		} else {
			$msg = "Seul les fichiers jpg, jpeg, webp et png sont autorisés";
		}
				
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php require('./libs/head.php') ?> <!--Partie Head-->
	<title>Échange de savoirs - Actualités - Une diversité générationnelle et culturelle.</title> <!--Titre-->
</head>

<body>
	<header><?php require('./libs/header.php') ?></header> <!--Partie Header-->
	<div class="hautCateg">
	<h5>Sur cette page, vous retrouverez toutes les actualités liées au projet Échange de savoirs</h5>
	<hr>
	</div>
	<!-------AFFICHAGE DES ACTUALITES--------->
	<section id="listActu" class="rubriqueAccueil sectiongeneral">
		<!--Affichage de la dernière intiative-->
		<?php foreach ($actuListe as $actuListes) { ?> <!--Affichage de la dernière intiative-->
			<?php 
				$taille = 350;
				if(strlen($actuListes['description']) > $taille) {
					$raccourci = substr($actuListes['description'], 0, $taille).'...';
				} else {
					$raccourci = $actuListes['description'];
				}
				$totalInit++;
			?>
			<article class="article">
				<div>
					<h2><?= $actuListes['titre'] ?></h2>
					<h6 class="messageSup">Par <b><?= $actuListes['auteur'] ?></b>, le <b><?= $actuListes['date_actu'] ?></b>.</h6><br/>
					<p id="descrIni<?= $totalInit ?>" style="display: inline-flex;"><?= $raccourci ?></p>			
					<p id="descrInitEntiere<?= $totalInit ?>" style="display: none;"><?= $actuListes['description'] ?></p>
					<button class="boutons" id="voirplus<?= $totalInit ?>">Voir plus</a>
					<input type="text" name="totalInit" id="totalInit" value="<?= $totalInit ?>" hidden="hidden">	
				</div>
				<?php if(!empty($actuListes['image'])) { ?>
					<img src="./media/actus/<?= $actuListes['image'] ?>" alt="<?= $actuListes['titre'] ?> - Echange de savoir">
				<?php } ?>
			</article>
		<?php } ?>
	</section>
	<input type="text" name="totalIniti" id="totalIniti" value="<?= $totalInit ?>" hidden="hidden">	
	<!-------FORMULAIRE DES ACTIVITES--------->
	<section id="formActu" class="sectiongeneral">
		<?php if(!empty($_SESSION['id']) AND $userinfo['grade']=='admin') { ?><!--Vérification si l'utilisateur est connecté et s'il à le droit d'écrire-->		
		<h1>Une nouvelle actualité ?</h1>
		<p>Pour informer les utilisateurs d'une nouvelle actualité, veuillez remplir le formulaire ci-dessous. 
Faîtes attention à la description de votre actualité, faites en sorte que tout le monde comprenne cette dernière.</p>
		<form id="formulaireActu" method="post" enctype="multipart/form-data" class="formulaire">
			<!--------TITRE------>
			<label for="titreActu">Titre de l'actualité:</label>
			<input type="text" name="titreActu" id="titreActu" placeholder="Titre">
			<!--------DESCRIPTION------>
			<label for="descrActu">Description de l'actualité:</label>
			<textarea name="descrActu" id="descrActu" placeholder="Description de l'actualité"></textarea>
			<!-------Image----->
			<label for="imageActu">Image de l'actualité:</label>
			<input type="file" name="imageActu" id="imageActu">
			<!-------Validation-->
			<input type="submit" name="valider" value="Valider" class="boutons" id="voirplus1">
			<!--Affichage d'un message d'erreur-->
			<?php
				if(isset($msg))	{
					echo '<p style="color:red;">'.$msg.'</p>';
				}
			?>
		</form>
		<?php } ?>
	</section>
	
	<footer><?php require('./libs/footer.php') ?></footer> <!--Partie Footer-->
	<script type="text/javascript">
		window.addEventListener('load',function(){
			/*---------AFFICHAGE TEXT ENTIER------------------------*/
			
			var totalIniti = document.getElementById('totalIniti').value;
			console.log(totalIniti);
			for(var i = 1; i<=totalIniti; i++) {	
				let verif = false;
				let voirplus = document.getElementById('voirplus'+i);
				let descrIni = document.getElementById('descrIni'+i);
				let descrInitEntiere = document.getElementById('descrInitEntiere'+i);
				voirplus.addEventListener('click',function(){
					if(verif == false) {
						verif = true;				
						descrIni.style.display="none";
						descrInitEntiere.style.display="inline-flex";
						voirplus.innerHTML = "Voir moins";
					} else {
						verif = false;				
						descrIni.style.display="inline-flex";
						descrInitEntiere.style.display="none";
						voirplus.innerHTML = "Voir plus";
					}
				})
			}
		})
	</script>
</body>
</html>