<!---------------------------------------------LOGO-------------------------------->
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
		<?php if(!empty($_SESSION['id'])) { ?>
			<li><a href="./profil.php" >Profil</a></li>
		<?php } else { ?>
			<li><a href="./connexion.php" >Connexion</a></li>
		<?php } ?>
	</ul>
</nav>
