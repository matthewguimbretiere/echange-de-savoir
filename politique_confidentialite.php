<?php
include_once('cookieconnect.php');
require('./libs/bdd/bdd.php');

$titre="Politiques de confidentialité"; //Nom de la page

?>
<!DOCTYPE html>
<html>
<head>
	<?php require('./libs/head.php') ?> <!--Partie Head-->
	<title>Échange de savoirs - <?= $titre ?> - Une diversité générationnelle et culturelle.</title> <!--Titre-->
</head>
<body>
	<header><?php require('./libs/header.php') ?></header> <!--Partie Header-->
	<!--POLITIQUE-->
	<section id="politique">
		<h1>Politiques de confidentialité</h1>
		<h2>Qui sommes-nous?</h2>
		<p>L'adresse de notre site web est <a href="http://matguimbretiere.alvaydata.net/appli_ptut">http://matguimbretiere.alvaydata.net/appli_ptut</a>.</p>
		<br/><br/>
		<h2>Utilisation des données personnelles collectées</h2>
		<p>Vos données personnelles ne seront utilisées que pour  le bon fonctionnement de<strong> ECHANGE DE SAVOIR</strong> et ne seront transmises à aucune tierce partie.</p>
		<br/>
		<strong>Commentaires</strong>
		<br/>
		<p>Quand vous laissez un commentaire sur notre site web, les données inscrites dans le formulaire de commentaire, mais aussi votre adresse IP et l'agent utilisateur de votre navigateur sont collectés pour nous aider à la détection des commentaires indésirables.</p>
		<br/>
		<p>Une chaîne anonymisée créée à partir de votre adresse de messagerie (également appelée hash) peut être envoyée au service Gravatar pour vérifier si vous utilisez ce dernier. Les clauses de confidentialité du service Gravatar sont disponible ici : <a href="https://automattic.com/privacy/">https://automattic.com/privacy/</a>. Après validation de votre commentaire, votre profil sera visible publiquement à côté de votre commentaire.</p>
		<br/>
		<strong>Médias</strong>
		<br/>
		<p>Si vous êtes un utilisateur ou une utilisatrice enregistré.e et que vous téléversez des images sur le site web, nous vous conseillons d'éviter de téléverser des images contenant des données EXIF de coordonées GPS. Les visiteursde votre site web peuvent télécharger et extraire des données de localisation depuis ces images.</p>
		<br/>
		<strong>Formulaires de contact</strong>
		<br/>
		<p>Les informations fournies dans les champs obligatoires sont nécessaires pour l'envoie de vos messages. Nous nous engageons à ne pas les utiliser à des fins commerciales (autre que pour <strong>ECHANGE DE SAVOIR</strong>), à respecter la confidentialité de celles-ci, et à ne pas fournir à une tierce partie.</p>
		<br/>
		<strong>Cookies</strong>
		<br/>
		<p>Si vous déposez un commentaire sur notre site, il vous sera proposé d'enregistrer votre nom, adresse de messagerie et site web dans les cookies. C'est uniquement pour votre confort afin de ne pas avoir à saisir ces informations si vous déposez un autre commentaire plus tard. Ces cookies expirent au bout d'un an.</p>
		<br/>
		<p>Si vous avez un compte et que vous vous connectez sur ce site, un cookie temporaire sera créé afin de déterminer si votre navigateur accepte les cookies. Il ne contient pas de données personnelles et sera supprimé automatiquement à la fermeture du navigateur.</p>
		<br/>
		<p>Lorsque vous vous connecterez, nous mettrons en place un certain nombre de cookies pour enregistrer vos informations de connexion et vos préférences d'écran. La durée de vie d'un cookie de connexion est de deux jours, celle d'un cookie d'option d'écran est d'un an. Si vous cochez "Se souvenir de moi", votre cookie de connexion sera conservé pendant deux semaines. Si vous vous déconnectez de votre compte, le cookie sera effacé.</p>
		<br/>
		<p>En modifiant ou en publiant une publication, un cookie supplémentaire sera enregistré dans votre navigateur. Ce cookie ne comprend aucune donnée personnelle. Il indique simplement l'ID de la publication que vous venez de modifier. Il expire au bout d'un jour.</p>
		<br/>
		<strong>Contenu embarqué depuis d'autres sites</strong>
		<br/>
		<p>Les articles de ce site peuvent inclure des contenus intégrés (par exemple des vidéos, images, articles...). Le contenu intégré depuis d'autres sites se comporte de la même manière que si le visiteur se rendait sur ce site.</p>
		<br/>
		<p>Ces sites web pourraient collecter des données sur vous, utiliser des cookies, embarquer des outils de suivis tiers, suivre vos interactions avec ces contenus embarqués si vous disposez d'un compte connecté sur leur site web.</p>

		<br/><br/>
		<h2>Utilisation et transmission de vos données personnelles</h2>
		<p>Vos données personnelles ne seront utilisées que pour le bon fonctionnement de <strong>ECHANGE DE SAVOIR</strong> et ne seront transmises à aucune tierce parties.</p>

		<br/><br/>
		<h2>Durées de stockage de vos données</h2>
		<p>Si vous laissez un commentaire, le commentaire et ses métadonnées sont conservés indéfiniment. Cela permet de reconnaître et approuver automatiquement les commentaires suivant au lieu de les laisser dans la file de modération.
Pour les utilisateurs et utilisatrices qui s'enregistrent sur notre site (si cela est possible), nous stockons également les données personnelles indiquées dans leur profil. Tous les utilisateurs et utilisatrices peuvent voir, modifier ou supprimer leurs informations personnelles à tout moment (à l'exception de leur nom d'utilisateur.ice). Les gestionnaires du site peuvent aussi voir et modifier ces informations.</p>

		<br/><br/>
		<h2>Les droits que vous avez sur vos données</h2>
		<p>Si vous avez un compte ou si vous avez laissé des commentaires sur le site, vous pouvez demander à recevoir un fichier contenant toutes les données personnelles que nous possédons à votre sujet, incluant celles que vous nous avez fournies. Vous pouvez également demander la suppression des données personnelles vous concernant. Cela ne prend pas en compte les données stockées à des fins administratives, légales ou pour des raisons de sécurité.</p>

		<br/><br/>
		<h2>Transmission de vos données personnelles</h2>
		<p>Les commentaires des visiteurs peuvent être vérifiés à l'aide d'un service automatisé de détection des commentaires indésirables.</p>

		<br/><br/>
		<h2>Informations de contact</h2>
		<p>Nous confirmons que les informations de contact sont à jour.</p>

		<br/><br/>
		<h2>Informations supplémentaires</h2>
		<strong>Comment nous protégeons vos données</strong><br/>
		<p>Le site internet <strong>ECHANGE DE SAVOIR</strong>, développé avec le CMS WordPress, est régulièrement mis à jour, ainsi que les différents plugins utilisés. Ainsi, les failles de sécurité WordPress sont corrigés efficacement. Nous utilisons également des outils de protection pour éviter que notre site web soit piraté.</p>
		<br/>
		<strong>Procédures mises en oeuvre en cas de fuite de données</strong><br/>
		<p>En cas de fuite de données, veuillez nous contacter pour les démarches à effectuer.</p>
		<br/>
		<strong>Les services tiers qui nous transmettent des données</strong><br/>
		<p>Les données fournies par des services tiers restent confidentielles.</p>
		<br/>
		<strong>Opérations de marketing automatisé et/ou de profilage réalisées à l'aide des données personnelles</strong><br/>
		<p><strong>ECHANGE DE SAVOIR</strong> n'utilise pas de processus marketing personnalisé ou de profilage.</p>
		<br/>
		<strong>Affichage des informations liées aux secteurs soumis à des régulations spécifiques</strong><br/>
		<p>Aucune régulation spécifique pour notre secteur d'activité..</p>
	</section>
	
	<footer><?php require('./libs/footer.php') ?></footer> <!--Partie Footer-->
</body>
</html>
