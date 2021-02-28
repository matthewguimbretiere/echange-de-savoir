<?php
session_start();

//$bdd = new PDO('mysql:host=localhost;dbname=appliptut', 'root', 'Mad13Mat29Fla07');
$bdd = new PDO('mysql:host=localhost;dbname=ptut', 'root', '');

if (!isset($_SESSION['id']) AND isset($_COOKIE['mail'],$_COOKIE['motdepasse']) AND !empty($_COOKIE['mail']) AND !empty($_COOKIE['motdepasse'])) {
	
	$requser = $bdd->prepare("SELECT * FROM membre WHERE mail = ? AND mdp = ?");
	$requser->execute(array($_COOKIE['mail'], $_COOKIE['motdepasse']));
	$userexist = $requser->rowCount();
	if($userexist == 1)
	{
		$userexist = $requser->fetch();
			$_SESSION['id'] = $userexist['id'];
			$_SESSION['mailConnect'] = $userexist['mail'];
			$_SESSION['mdpConnect'] = $userinfo['mdp'];
			header("Location: index.php");
	} 
}
?>