<?php
include_once('cookieconnect.php');
require('./libs/bdd/bdd.php');

$titre="Accueil"; //Nom de la page

/*---------Recherche de la dernière intiative------*/
$pdoListInit = $bdd->prepare('SELECT * FROM initiative ORDER BY id_init DESC LIMIT 1');
$executeIsOk = $pdoListInit->execute();
$initListe = $pdoListInit->fetchAll();
/*---------Recherche de la dernière actualité------*/
$pdoListActu = $bdd->prepare('SELECT * FROM actualite ORDER BY id_actu DESC LIMIT 1');
$executeIsOk = $pdoListActu->execute();
$actuListe = $pdoListActu->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
	<?php require('./libs/head.php') ?> <!--Partie Head-->
	<title>Échange de savoirs - <?= $titre ?> - Une diversité générationnelle et culturelle.</title> <!--Titre-->
	<!--STYLE CAROUSEL-->
	<style type="text/css">
		* {
	box-sizing: border-box;
}

body {
	font-family: sans-serif;
	overflow: scroll;
	overflow-x: hidden;
}



label {
	background: #444;
	color: #fff;
	transition: transform 400ms ease-out;
	display: inline-block;
  	min-height: 40%;
	width: 80vw;
	height: 40vh;
	position: relative;
	z-index: 1;

	text-align: center;
	line-height: 40vh;
}

form {
	margin-right:auto;
	margin-left:auto;
	width: 80vw;
	right: 10vw;
	overflow: hidden;
	white-space: nowrap;
}
input {
	position: absolute;
}

.keys {
	position: fixed;
	z-index: 10;
	bottom: 0;
	left: 0;
	right: 0;
	padding: 1rem;
	color: #fff;
	text-align: center;
	transition: all 300ms linear;
	opacity: 0;
}

input:focus ~ .keys {
	opacity: 0.8;
}

input:nth-of-type(1):checked ~ label:nth-of-type(1), 
input:nth-of-type(2):checked ~ label:nth-of-type(2),
input:nth-of-type(3):checked ~ label:nth-of-type(3){
   z-index: 0;
}

input:nth-of-type(1):checked ~ label {
	transform: translate3d(0, 0, 0);
}

input:nth-of-type(2):checked ~ label {
	transform: translate3d(-100%, 0, 0);
}

input:nth-of-type(3):checked ~ label {
	transform: translate3d(-200%, 0, 0);
}



label {
	background: #444;
	background-size: cover;
	font-size: 3rem;
}


label:before,
label:after {
	color: white;
	display: block;
	background: rgba(255,255,255,0.2);
	position: absolute;
	padding: 1rem;
	font-size: 3rem;
	height: 10rem;
	vertical-align: middle;
	line-height: 10rem;
	top: 50%;
	transform: translate3d(0, -50%, 0);
	cursor: pointer;
}

label:before {
	content: "\276D";
	right: 100%;
	border-top-left-radius: 50%;
	border-bottom-left-radius: 50%;
}

label:after {
	content: "\276C";
	left: 100%;
	border-top-right-radius: 50%;
	border-bottom-right-radius: 50%;
}
label img{
	height: 40vh;
}
@media screen and (max-width: 767px){
	label{
		line-height: 20vh;
		height: 20vh;
	}
	label img{
		height: 20vh;
	}
	input:nth-of-type(2):checked ~ label {
	    transform: translate3d(-105%, 0, 0);
	}
}
	</style>
</head>
<body>
	<header><?php require('./libs/header.php') ?></header> <!--Partie Header-->
	<!------CAROUSEL-------->
	<section id="carousel">
		<form>
			<input type="radio" name="fancy" autofocus value="communautedecommune" id="communautedecommune" hidden="" />
			<input type="radio" name="fancy" value="foot" id="foot" hidden="" />			
			<label for="communautedecommune"><img src="./media/diapo/communaute_de_commune_du_civraisien_en_poitou_echange_de_savoir_paysage.png" alt="communaute_de_commune_du_civraisien_en_poitou_echange_de_savoir_paysage"></label>
			<label for="foot"><img src="./media/diapo/communaute_de_commune_du_civraisien_en_poitou_echange_de_savoir2.png" alt="communaute_de_commune_du_civraisien_en_poitou_echange_de_savoir2"></label>
		</form>
	</section>
	<!------PRESENTATION-------->
	<section id="presentation">
		<p>L'<b>Échange de savoirs</b> est un projet mis en place par la communauté de communes du Civraisien et est destiné à tous les habitants du civraisien qui souhaitent partager leurs connaissances ou en découvrir de nouvelles. C’est un projet participatif où chacun est libre de créer un atelier qu’il animera à des personnes intéressées dans des locaux mis en place par les communes de la région. L'<b>Échange de savoirs</b> à pour but de permettre aux habitants de partager leur savoir, se découvrir une passion ou encore faire de belles rencontres.</p>
		<br/>
		<p>Sur ce site web, vous trouverez les différentes initiatives mises en place, les actualités liées au projet, un formulaire vous permettant de vous inscrire à une activité ou de proposer votre activité aux autres, une page interactive vous permettra  de partager vos avis et commentaires. Pour cela il vous suffit juste de vous créer un compte <a href="./connexion.php">en cliquant ici</a>.</p>
	</section>
	<!------INITIATIVE-------->
	<section id="initiative" class="rubriqueAccueil sectiongeneral">
		<h1 class="fade-in">Dernières initiatives</h1>
		<h6 class="messageSup">| Voici un exemple des dernières initiatives mises en place par nos concitoyens.</h6>
		<hr>
		<?php foreach ($initListe as $initListes) { ?> <!--Affichage de la dernière intiative-->
			<article class="article">
				<div>
					<h2><?= $initListes['titre'] ?>, <b><?= $initListes['cout'] ?>€/heures</b></h2>
					<h6 class="messageSup">Par <b><?= $initListes['auteur'] ?></b>,<br/>
					Prochain atelier: <b><?= $initListes['dateInit'] ?></b>, <?= $initListes['lieu'] ?>.</h6><br/>
					<p><?= $initListes['description'] ?></p>
					<a href="./initiatives.php" class="boutons">Voir plus...</a>
				</div>
				<?php if(!empty($initListes['image'])) { ?>
					<img src="./media/init/<?= $initListes['image'] ?>" alt="<?= $initListes['titre'] ?> - Echange de savoir">
				<?php } ?>
			</article>
		<?php } ?>
	</section>
	<!------ACTUALITES-------->
	<section id="actualite" class="rubriqueAccueil sectiongeneral">
		<h1 class="fade-in">Dernières actualités</h1>
		<h6 class="messageSup">| Cette section regroupe les récentes actualités liées au projet.</h6>
		<hr>
		<?php foreach ($actuListe as $actuListes) { ?> <!--Affichage de la dernière actualité-->
			<?php 
				$taille = 350;
				if(strlen($actuListes['description']) > $taille) {
					$raccourci = substr($actuListes['description'], 0, $taille).'...';
				} else {
					$raccourci = $actuListes['description'];
				}
			?>
			<article class="article">
				<div>
					<h2><?= $actuListes['titre'] ?></h2>
					<h6 class="messageSup">Par <b><?= $actuListes['auteur'] ?></b>, le <b><?= $actuListes['date_actu'] ?></b>.</h6><br/>
					<p><?= $raccourci ?></p>
					<a href="./actualites.php" class="boutons">Voir plus...</a>
				</div>
				<?php if(!empty($actuListes['image'])) { ?>
					<img src="./media/actus/<?= $actuListes['image'] ?>" alt="<?= $actuListes['titre'] ?> - Echange de savoir">
				<?php } ?>
			</article>
		<?php } ?>
	</section>
	
	<footer><?php require('./libs/footer.php') ?></footer> <!--Partie Footer-->
</body>
</html>
