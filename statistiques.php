<?php
include_once('cookieconnect.php');
require('./libs/bdd/bdd.php');

$titre="Avis et Statistiques"; //Nom de la page

/*---------Recherche des 3 derniers avis------*/
$pdoListAvis = $bdd->prepare('SELECT * FROM avis ORDER BY id_avis DESC LIMIT 3');
$executeIsOk = $pdoListAvis->execute();
$avisListe = $pdoListAvis->fetchAll();
/*---------Recherche de tout les avis------*/
$pdoListAvisTout = $bdd->prepare('SELECT * FROM avis');
$executeIsOk = $pdoListAvisTout->execute();
$avisListeTout = $pdoListAvisTout->fetchAll();
/*---------INSCRIPITON AVI------*/
if (isset($_POST['formavi'])) {
	if (!empty($_POST['categ'])) {
		if ($_POST['categ'] == "avis") {
			if (!empty($_POST['aviForm']) AND !empty($_POST['noteform'])) {
				$aviForm = htmlspecialchars($_POST['aviForm']);
				$noteform = htmlspecialchars($_POST['noteform']);
				if ($noteform <=5) {
					/*--VERIFICATION AVIS--*/
					$reqAVI = $bdd->prepare("SELECT * FROM avis WHERE id_auteur = ? AND avi = ? AND note = ?");
				    $reqAVI->execute(array($_SESSION['id'],$aviForm,$noteform));
				    $aviexist = $reqAVI->rowCount();

				    if ($aviexist ==0 ) {
				       	$insertAvis = $bdd->prepare('INSERT INTO avis(id_auteur,avi,note,categ) VALUES(?,?,?,?) ');
						$insertAvis->execute(array($_SESSION['id'],$aviForm,$noteform,$_POST['categ']));
						$msg = "Votre avis est envoyé !";
				    }
				} else {
					$msg = "Veuillez mettre une note entre 0 et 5.";
				}
			} else {
				$msg = "Veuillez remplir tout les champs.";
			}
		} elseif($_POST['categ']=="demande") {
			if (!empty($_POST['demandeForm'])) {
				$demandeForm = htmlspecialchars($_POST['demandeForm']);
				/*--VERIFICATION DEMANDE--*/
				$reqDEMANDE = $bdd->prepare("SELECT * FROM avis WHERE id_auteur = ? AND avi = ?");
				$reqDEMANDE->execute(array($_SESSION['id'],$demandeForm));
				$demandexist = $reqDEMANDE->rowCount();

				if ($demandexist ==0 ) {
				   	$insertDEMANDE = $bdd->prepare('INSERT INTO avis(id_auteur,avi,categ) VALUES(?,?,?) ');
					$insertDEMANDE->execute(array($_SESSION['id'],$demandeForm,$_POST['categ']));
					$msg = "Votre demande est envoyé !";
				}
			} else {
				$msg = "Veuillez remplir tout les champs.";
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
	<!------FORMULAIRE AVIS-------->
	<div class="hautCateg">						
		<h5>Pour nous donner votre avis</h5>
		<hr>
	</div>
	<section id="avisForm" class="sectiongeneral">
		<p>Afin de nous permettre d’améliorer nos services ainsi que votre expérience avec Échange de savoirs nous aimerions avoir vos différents retours par rapport au projet. 
		<br>Vous pouvez également poser vos questions à travers ce formulaire. Vous recevrez une réponse par e-mail dès que possible.</p>
		<form method="post" id="formulaireAvi" class="formulaire">
			<label for="categ">Catégorie de la demande :</label>
			<select name="categ" id="categ">
				<option value="avis">Avis</option>
				<option value="demande">Demande</option>
			</select>
			<label for="aviForm" id="labAvis">Votre demande :</label>
			<textarea id="aviForm" name="aviForm" rows="7" cols="150" ></textarea>
			
			<label for="demandeForm" id="labDemande" style="display: none;">Votre demande :</label>
			
			<textarea id="demandeForm" name="demandeForm"rows="7" cols="150"  style="display: none;"></textarea>
			<label for="noteform" id="labnote">Une note sur 5 :</label>
			
			<input type="number" name="noteform" id="noteform" min="0" max="5">
			<label for="email">Votre adresse e-mail :</label>
			<input type="email" id="email" size="30" required>
			<input type="submit" name="formavi" class="boutons">
			<?php
				if(isset($msg))	{
					echo '<p style="color:red;">'.$msg.'</p>';
				}
			?>
		</form>
	</section>
	<!-----QUELQUES AVIS--------->
	<div class="hautCateg">				
		<h5>Quelques avis</h5>
		<hr>
	</div>
	<section id="avisListe" class="sectiongeneral">
		<?php foreach ($avisListe as $avisListes) { 
			if($avisListes['categ']=="avis") {
			$requser = $bdd->prepare('SELECT pseudo FROM membre WHERE id = ?');
			$requser->execute(array($avisListes['id_auteur']));
			$auteurinfo = $requser->fetch();
		?>
			<article id="artAvi" class="article formulaire">
				<h3>Par <?= $auteurinfo['pseudo'] ?></h3>
				<h2><?= $avisListes['note'] ?> / 5</h2>
				<p><?= $avisListes['avi'] ?></p>
			</article>
		<?php }} ?>
	</section>
	<!-----QUELQUES STATISTIQUES--------->
	<div class="hautCateg">		
		<h5>Quelques statistiques à propos du projet Echange de savoir</h5>
		<hr>
	</div>
	<section id="stat" class="sectiongeneral">
		<h3>Au cours de la première année du projet Echange de savoir :</h3>
		<br>
		<?php
		/*--NOMBRE D'INITIATIVES--*/
			$reqInit = $bdd->prepare("SELECT * FROM initiative");
			$reqInit->execute();
			$initcount = $reqInit->rowCount();
		/*--NOMBRE DE PARTICIPANT--*/
			$reqPart = $bdd->prepare("SELECT * FROM participation");
			$reqPart->execute();
			$partcount = $reqPart->rowCount();
		/*--NOMBRE DE GERANT--*/
			$reqAdmin = $bdd->prepare("SELECT * FROM membre WHERE grade = 'admin'");
			$reqAdmin->execute();
			$admincount = $reqAdmin->rowCount();
		/*--NOMBRE DE NOTES--*/
			$reqNote = $bdd->prepare("SELECT COUNT(*) AS nb_note FROM avis WHERE categ = 'avis'");
			$reqNote->execute();
			$noteinfo = $reqNote->fetch();
		/*--MOYENNE NOTES--*/
			$note = 0;
			foreach ($avisListeTout as $avisListesTout) { 
				if($avisListesTout['categ']=="avis") {
					$note = $note + $avisListesTout['note'];
				}
			}
			$note = $note/$noteinfo['nb_note'];
		/*---------SOMME DU PRIX DES INITIATIVES------*/
			$reqCout = $bdd->prepare("SELECT SUM(cout) AS cout_init FROM initiative");
			$reqCout->execute();
			$coutinfo = $reqCout->fetch();
		/*--COUT MOYEN--*/
			$coutMoy = $coutinfo['cout_init'] / $initcount;

		?>
		<ul>
			<li><b><?= $initcount ?></b> différents ateliers ont été créé</li>
			<li><b><?= $partcount ?></b> personnes ont participé au projet</li>
			<li><b><?= $admincount ?></b> gèrent au quotidien l’organisation des ateliers ainsi que la gestion du site web</li>
			<li>La moyenne des notes globales est <b><?= $note ?> / 5</b></li>
			<li>Le coût moyen individuel global est <b><?= $coutMoy ?> €</b></li>
		</ul>
		<br>
		<strong><h4>Merci à vous pour votre participation lors de cette année et espérons que la prochaine soit encore plus belle.</h4></strong>
	</section>

	<footer><?php require('./libs/footer.php') ?></footer> <!--Partie Footer-->
	<script type="text/javascript">
		/*----------VERIFICATION AUTRE FORMULAIRE INITIATIVE-------*/
		var categ = document.getElementById('categ');
		var avisForm = document.getElementById('avisForm');
		var demandeForm = document.getElementById('demandeForm');
		var labAvis = document.getElementById('labAvis');
		var labDemande = document.getElementById('labDemande');
		var labnote = document.getElementById('labnote');
		var noteform = document.getElementById('noteform');

		categ.addEventListener( "change", function ( e ) {
			if(e.target.value == "avis"){
				aviForm.style.display="inline-flex";
				labAvis.style.display="inline-flex";	
				labnote.style.display="inline-flex";
				noteform.style.display="inline-flex";				
				demandeForm.style.display="none";
				labDemande.style.display="none";
			} else {
				if(e.target.value == "demande"){
					aviForm.style.display="none";
					labAvis.style.display="none";
					labnote.style.display="none";
					noteform.style.display="none";
					demandeForm.style.display="inline-flex";
					labDemande.style.display="inline-flex";
				}
			}
		})
	</script>
</body>
</html>