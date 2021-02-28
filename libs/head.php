<?php
include_once('cookieconnect.php');
require('./libs/bdd/bdd.php');

if (!empty($_SESSION['id'])) {
	$requser = $bdd->prepare('SELECT * FROM membre WHERE id = ?');
	$requser->execute(array($_SESSION['id']));
	$userinfo = $requser->fetch();
}
?>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="icon" type="image/ico" href="./media/img/logo_echange_de_savoir_civray_loisirs.ico" />
<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="./js/app.js"></script>
<meta name="viewport" content="width=device-width">	