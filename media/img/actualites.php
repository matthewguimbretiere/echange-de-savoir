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
	<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="icon" type="image/ico" href="./media/img/logo_echange_de_savoir_civray_loisirs.ico" />
<link rel="stylesheet" href="./css/style.css" type="text/css" media="all"> 
<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="./js/app.js"></script> <!--Partie Head-->
	<title>Echange de savoir - Actualités - Une diversité générationnelle et culturelle.</title> <!--Titre-->
</head>

<body>
	<header><!---------------------------------------------LOGO-------------------------------->
<div id="logoHeader">
	<img src="./media/img/icone_logo_echange_de_savoir.jpg" alt="Logo de Echange de savoir - Organisation de communauté de commune dans l'échange entre les générations" id="logoImg">
	<div>
		<h1>Echange de savoir</h1>
		<h3>Une diversité générationnelle et culturelle</h3>
	</div>
</div>
<!---------------------------------------------MENU-------------------------------->
<nav>
	<ul>
		<li><a href="./index.php" >Accueil</a></li>
		<li><a href="./initiatives.php" >Les initiatives</a></li>
		<li><a href="./actualites.php" >Les actualités</a></li>
		<li><a href="./statistiques.php" >Statistiques et avis</a></li>
					<li><a href="./profil.php" >Profil</a></li>
			</ul>
</nav>
</header> <!--Partie Header-->
	<div id="hautActu">
	<h1>Actualités</h1>
	<h5>Sur cette page, vous retrouverez toutes les actualités liées au projet Echange de savoir</h5>
	<hr>
	</div>
	<!-------AFFICHAGE DES ACTUALITES--------->
	<section id="listIni2">
		 <!--Affichage de la dernière intiative-->
						<article>
				<div>
					<h2>De nouveaux locaux proposés par la mairie de Civray</h2>
					<img src="./media/img/Civray_Mairie.jpg" alt="Mairie de Civray">
										<div>
						<h6>Par <b>Claire Dubois</b>, le <b>12 mai 2020</b>.</h6><br/>
						<p id="descrIni1" style="display: inline-flex;">Bonjour à tous,
						<br>
						<br> 
Je suis très contente de vous annoncer que la ville de Civray a réussi à trouver de nouveaux locaux pour que vous puissiez animer vos ateliers. La salle polyvalente du lycée André Theuriet sera disponible tous les mercredis après midi, les samedis et durant les vacances scolaires de 10 heures à 17 heures. Nous sommes très...</p>			
						<p id="descrInitEntiere1" style="display: none;">Bonjour à tous, 
							<br>
							<br>
Je suis très contente de vous annoncer que la ville de Civray a réussi à trouver de nouveaux locaux pour que vous puissiez animer vos ateliers. La salle polyvalente du lycée André Theuriet sera disponible tous les mercredis après midi, les samedis et durant les vacances scolaires de 10 heures à 17 heures. Nous sommes très content de l’aide que le lycée nous apporte et cela pourra répondre à la forte demande en terme d’initiatives que vous souhaitez mettre en place. Je vous remercie pour cette engouement.
<br>
<br>
Cordialement, 
<br>
<br>
Claire Dubois
</p>						
						<button id="voirplus1">Voir plus</a>
					</div>	
					<input type="text" name="totalInit" id="totalInit" value="1" hidden="hidden">
				
					<div>
					<h2>Intégration d'une nouvelle commune au projet</h2>
					<img src="./media/img/saintsaviol.png" alt="Logo ville Saint Saviol 86 vienne">
					</div>
										<div>
						<h6>Par <b>Claire Dubois</b>, le <b>9 mai 2020</b>.</h6><br/>
						<p id="descrIni1" style="display: inline-flex;">Bonjour à tous,
<br>
<br>
Nous avons une bonne nouvelle à vous annoncer, en effet la commune de Saint-Saviol à décider de rejoindre le projet Echange de savoir. C'est la sixième commune qui nous mets à disposition des locaux municipaux afin d'exercer nos activités. Dans un...</p>			
						<p id="descrInitEntiere1" style="display: none;">Bonjour à tous,
							<br>
							<br>

Nous avons une bonne nouvelle à vous annoncer, en effet la commune de Saint-Saviol à décider de rejoindre le projet Echange de savoir. C'est la sixième commune qui nous mets à disposition des locaux municipaux afin d'exercer nos activités. Dans un premier temps, un espace sportif ainsi qu'une salle de classe seront disponibles les week-ends, de 10 heures à 18 heures. Nous remercions la commune pour leur aide et nous espérons que d'autres communes nous rejoindrons afin d'étendre encore plus le projet.
<br>
<br>
Cordialement, 
<br>
<br>
Claire Dubois
</p>						
						<button id="voirplus1">Voir plus</a>
					</div>	
					<input type="text" name="totalInit" id="totalInit" value="1" hidden="hidden">				
				</div>
			</article>
			</section>
	<!-------FORMULAIRE DES INITIATIVES--------->
	<section id="formIni2">
		<h1>Une nouvelle actualité ?</h1>
					<h2>Vous n'avez pas accès à cette section</h2>
			</section>
	<footer><div>
	<b>©2020 TOF LA WIN</b>
	<p>Tous droits réservés</p>
</div>

<div>
	<nav>
		<ul>
			<li><a href="./mention_legal.php">Mention légales</a></li>
			<li><a href="./politique_confidentialite.php">Politique de confidentialite</a></li>
		</ul>
	</nav>
</div></footer> <!--Partie Footer-->
	<script type="text/javascript">
		window.addEventListener('load',function(){
			/*---------AFFICHAGE TEXT ENTIER------------------------*/
			var totalInit = document.getElementById('totalInit').value;
			for(var i = 1; i<=totalInit; i++) {	
				var verif = false;
				var voirplus = document.getElementById('voirplus'+i);
				var descrIni = document.getElementById('descrIni'+i);
				var descrInitEntiere = document.getElementById('descrInitEntiere'+i);
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