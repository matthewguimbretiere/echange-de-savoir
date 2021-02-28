<?php 
include_once('cookieconnect.php');
require('./libs/bdd/bdd.php');

if(isset($_GET['section'])){
	$section = htmlspecialchars($_GET['section']);
} else {
	$section = "";
}

$titre="Connexion / Inscription"; //Nom de la page
/*---------------------------------------------------------REDIRECTION-----------------------------------*/
if (isset($_POST['goRecup'])) {
	header("Location: ./connexion.php?section=recuperation");
}
if (isset($_POST['goInscri'])) {
	header("Location: ./connexion.php?section=inscription");
}
if (isset($_POST['goConnection'])) {
	header("Location: ./connexion.php");
}
/*----------CONNEXION-----------*/
if (isset($_POST['formConnect'])) {
	if (!empty($_POST['mailConnect']) AND !empty($_POST['mdpConnect'])) {
		$mailConnect = htmlspecialchars($_POST['mailConnect']);
		$mdpConnect = htmlspecialchars($_POST['mdpConnect']);

		$mdpConnect = sha1($mdpConnect);
		$requser = $bdd->prepare("SELECT * FROM membre WHERE mail = ? AND mdp = ?");
		$requser->execute(array($mailConnect, $mdpConnect));
		$userexist = $requser->rowCount();
		if($userexist == 1)	{
			if(isset($_POST['checkbox'])) {
				setcookie('pseudo',$mailConnect,time()+365*24*3600,null,null,false,true);
				setcookie('password',$mdpConnect,time()+365*24*3600,null,null,false,true);
			}
			$userinfo = $requser->fetch();
			$_SESSION['id'] = $userinfo['id'];
			$_SESSION['mailConnect'] = $userinfo['mail'];
			$_SESSION['mdpConnect'] = $userinfo['mdp'];
			header('Location: ./index.php');
		} else {
			$requser = $bdd->prepare("SELECT * FROM membre WHERE pseudo = ? AND mdp = ?");
			$requser->execute(array($mailConnect, $mdpConnect));
			$userexist = $requser->rowCount();
			if($userexist == 1) {
				if(isset($_POST['checkbox'])) {
					setcookie('pseudo',$pseudoconnect,time()+365*24*3600,null,null,false,true);
					setcookie('password',$mdpconnect,time()+365*24*3600,null,null,false,true);
				}
				$userinfo = $requser->fetch();
				$_SESSION['id'] = $userinfo['id'];
				$_SESSION['mailConnect'] = $userinfo['mail'];
				$_SESSION['mdpConnect'] = $userinfo['mdp'];
				header('Location: ./index.php');
			} else {
				$msg = "Mauvais pseudo ou mot de passe";
			}
		} 
	} else {
		$msg = "Veuillez remplir tout les champs.";
	}
}
/*----------INSCRIPTION-----------*/


if(isset($_POST['formInscri'])) {
	$header="MIME-Version: 1.0\r\n";
	$header.='From:"echange_de_savoir.fr"<echangedesavoir@gmail.com>'."\n";
	$header.='Content-Type:text/html; charset="utf-8"'."\n";
	$header.='Content-Transfer-Encoding: 8bit';

	$messageMail='
	<html>
		<body>
			<div align="center">
				Votre compte a bien été créé !
				<br/>
			</div>
		</body>
	</html>
	';
	/*--DEFINITION ADRESSE--*/
	if (!empty($_POST['adrInscri'])) {
		$adrInscri = htmlspecialchars($_POST['adrInscri']);
	} else {
		$adrInscri = "";
	}
	/*--DEFINITION VILLE--*/
	if (!empty($_POST['villeInscri'])) {
		$villeInscri = htmlspecialchars($_POST['villeInscri']);
	} else {
		$villeInscri = "";
	}
	/*--DEFINITION CP--*/
	if (!empty($_POST['cpInscri'])) {
		$cpInscri = htmlspecialchars($_POST['cpInscri']);
	} else {
		$cpInscri = "";
	}
	/*--DEFINITION PROFESSION--*/
	if (!empty($_POST['profInscri'])) {
		$profInscri = htmlspecialchars($_POST['profInscri']);
	} else {
		$profInscri = "";
	}

	if (!empty($_POST['pseudoInscri']) AND !empty($_POST['prenomInscri']) AND !empty($_POST['nomInscri']) AND !empty($_POST['mailInscri']) AND !empty($_POST['mdpInscri']) AND !empty($_POST['confMdpInscri']) AND !empty($_POST['telInscri'])) {
		/*--DEFINITION PSEUDO--*/
		$pseudoInscri = htmlspecialchars($_POST['pseudoInscri']);
		/*--DEFINITION PRENOM--*/
		$prenomInscri = htmlspecialchars($_POST['prenomInscri']);
		/*--DEFINITION NOM--*/
		$nomInscri = htmlspecialchars($_POST['nomInscri']);
		/*--DEFINITION MAIL--*/
		$mailInscri = htmlspecialchars($_POST['mailInscri']);
		/*--DEFINITION MDP--*/
		$mdpInscri = sha1($_POST['mdpInscri']);
		/*--DEFINITION CONF MDP--*/
		$confMdpInscri = sha1($_POST['confMdpInscri']);
		/*--DEFINITION TEL--*/
		$telInscri = htmlspecialchars($_POST['telInscri']);

		$pseudoInscriTaille = strlen($pseudoInscri);
		if($pseudoInscriTaille<=255){
			$reqpseudo = $bdd->prepare("SELECT * FROM membre WHERE pseudo = ?");
			$reqpseudo->execute(array($pseudoInscri));
			$pseudoexist = $reqpseudo->rowCount();
			if($pseudoexist ==0){
				if(filter_var($mailInscri, FILTER_VALIDATE_EMAIL)) {
					$reqmail = $bdd->prepare("SELECT * FROM membre WHERE mail = ?");
               		$reqmail->execute(array($mailInscri));
               		$mailexist = $reqmail->rowCount();
               		if($mailexist == 0) {
               			if ($mdpInscri == $confMdpInscri) {               				
							if( is_numeric($telInscri) && strlen($telInscri) == 10){
	               				$insertmbr = $bdd->prepare('INSERT INTO membre(prenom,nom,pseudo,adresse,ville,cp,tel,mail,profession,mdp) VALUES(?,?,?,?,?,?,?,?,?,?)');
								$insertmbr->execute(array($prenomInscri,$nomInscri,$pseudoInscri,$adrInscri,$villeInscri,$cpInscri,$telInscri,$mailInscri,$profInscri,$mdpInscri));
								mail($mail, "Confirmation inscription", $messageMail, $header);
								$erreur="Votre compte a bien été créer !";
								header("Location: connexion.php");
							} else {
								$msgInscri = "Mauvais numéro de téléphone.";
							}
               			} else {
               				$msgInscri = "Vos mot de passe ne correspondent pas.";
               			}
               		} else {
               			$msgInscri = "Adresse mail déjà utilisée.";
               		}
				} else {
					$msgInscri = "Votre adresse mail n'est pas valide.";
				}
			} else {
				$msgInscri = "Un compte utilise déjà ce pseudo.";
			}
		} else {
			$msgInscri = "Votre pseudo ne doit pas dépasser 255 caractères.";
		}
	} else {
		$msgInscri = "Veuillez remplir tous les champs obligatoires.";
	}
}
/*----------RECUPERATION MDP-----------*/
if(isset($_GET['partie'])){
	$partie = htmlspecialchars($_GET['partie']);

} else {
	$partie = "";
}
if(isset($_POST['recup_submit'],$_POST['recup_mail'])){
	if (!empty($_POST['recup_mail'])) {
		$recup_mail = htmlspecialchars($_POST['recup_mail']);
		if (filter_var($recup_mail,FILTER_VALIDATE_EMAIL)) {
			$mailexist = $bdd->prepare('SELECT id,pseudo FROM membre WHERE mail = ?');
			$mailexist->execute(array($recup_mail));
			$mailexist_count = $mailexist->rowCount();
			if($mailexist_count == 1){
				$pseudo = $mailexist->fetch();
				$pseudo = $pseudo['pseudo'];
				$_SESSION['recup_mail'] = $recup_mail;
				$_SESSION['recup_code'] = "";
				for($i=0;$i<8;$i++){
					$_SESSION['recup_code'] .= mt_rand(0,9);
				}
				$mail_recup_exist = $bdd->prepare('SELECT id FROM recuperation WHERE mail = ?');
				$mail_recup_exist->execute(array($recup_mail));
				$mail_recup_exist = $mail_recup_exist->rowCount();

				$recup_insert = $bdd->prepare('INSERT INTO recuperation(mail,code) VALUES (?,?)');
				$recup_insert->execute(array($recup_mail,$_SESSION['recup_code']));
				$header="MIME-Version: 1.0\r\n";
$header.='From:"lotof.fr"<webmaster@toflawin.site>'."\n";
$header.='Content-Type:text/html; charset="utf-8"'."\n";
$header.='Content-Transfer-Encoding: 8bit';
		         $message = '
			         <html>
			         <body>
			           <font color="#303030";>
			             <div align="center">
			               <table width="600px">
			                 <tr>
			                   <td>
			                     
			                     <div align="center">Bonjour <b>'.$pseudo.'</b>,</div>
			                     Voici votre code de récupération: <b>'.$_SESSION['recup_code'].'</b>
			                     A bientôt sur <a href="lotof.fr">echange_de_savoir.fr</a> !
			                     
			                   </td>
			                 </tr>
			                 <tr>
			                   <td align="center">
			                     <font size="2">
			                       Ceci est un email automatique, merci de ne pas y répondre
			                     </font>
			                   </td>
			                 </tr>
			               </table>
			             </div>
			           </font>
			         </body>
			         </html>
		         ';

         mail($_SESSION['recup_mail'], "Récupération de mot de passe - echange_de_savoir.fr",$message,$header);
        	header("Location: ./connexion.php?section=recuperation&partie=code");
			} else {
				$msgRecup = "Cette adresse mail n'est pas enregistrée.";
			}
		} else {
			$msgRecup = "Adresse mail invalide";
		}
	} else {
		$msgRecup = "Veuillez entrer votre adresse mail.";
	}
}

if (isset($_POST['verif_submit'],$_POST['verif_code'])) {
	if (!empty($_POST['verif_code'])) {
		
		if ($_POST['verif_code'] == $_SESSION['recup_code']) {
			$del_req = $bdd->prepare('DELETE FROM recuperation WHERE mail = ?');
			$del_req->execute(array($_SESSION['recup_mail']));
			header("Location: ./connexion.php?section=recuperation&partie=changemdp");
		} else {
			$msgRecup = "Code invalide";
		}
	} else {
		$msgRecup = "Veuillez entrer votre code de confirmation";
	}
}

if (isset($_POST['change_submit'])) {
	if (isset($_POST['change_mdp'],$_POST['change_mdpc'])) {
		$mdp = htmlspecialchars($_POST['change_mdp']);
		$mdpc = htmlspecialchars($_POST['change_mdpc']);
		if (!empty($mdp) AND !empty($mdpc)) {
			if ($mdp == $mdpc) {
				$mdp = sha1($mdp);
				$ins_mdp = $bdd->prepare('UPDATE membre SET mdp = ? WHERE mail = ?');
				$ins_mdp->execute(array($mdp,$_SESSION['recup_mail']));
				header("Location: ./connexion.php");
			} else {
				$msgRecup ="Vos mots de passe ne correspondent pas";
			}
		} else {
			$msgRecup = "Veuillez remplir tous les champs";
		}
	} else {
		$msgRecup = "Veuillez remplir tous les champs";
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
	<!-------ESPACE CONNEXION------------------------------------------------------>
	<?php if (empty($section)) { ?>
		<section id="connexion" class="formulaire">
			<h1>Se connecter</h1>
			<form id="formconnexion" method="post">
				<!--MAIL-->
				<label for="mailConnect">Adresse mail ou pseudo</label>
				<input type="text" name="mailConnect" id="mailConnect" placeholder="Adresse mail ou pseudo">
				<!--MOT DE PASSE-->
				<label for="mdpConnect">Mot de passe</label>
				<input type="password" name="mdpConnect" id="mdpConnect" placeholder="Mot de passe">
				<!--SE SOUVENIR DE MOI-->
				<div><label for="case">Se souvenir de moi</label>
				<input type="checkbox" name="checkbox" id="case"></div>
				<!--VALIDER-->
				<input type="submit" name="formConnect" class="boutons">
				<!--Affichage d'un message d'erreur-->
				<?php
					if(isset($msg))	{
						echo '<p style="color:red;">'.$msg.'</p>';
					}
				?>
				<!-----------------------------Inscription/Recup----------------->
				<div>
					<input type="submit" name="goInscri"  class="boutons" value="S'inscrire" class="btn">
					<input type="submit" name="goRecup" class="boutons" value="Mot de passe oublié ?" class="btn">
				</div>

			</form>
		</section>
	<?php }elseif($section == "inscription") { ?>
		<!-------ESPACE INSCRIPTION------------------------------------------------------>
		<section id="inscription" class="formulaire">
			<h1>Inscription</h1>
			<form method="post">
				<label for="pseudoInscri">Pseudo*</label>
				<input type="text" name="pseudoInscri" id="pseudoInscri" placeholder="Pseudo">
				<label for="prenomInscri">Prénom*</label>
				<input type="text" name="prenomInscri" id="prenomInscri" placeholder="Prénom">
				<label for="nomInscri">Nom*</label>
				<input type="text" name="nomInscri" id="nomInscri" placeholder="Nom">
				<label for="mailInscri">Adresse mail*</label>
				<input type="email" name="mailInscri" id="mailInscri" placeholder="exemple@domain.com">
				<label for="mdpInscri">Mot de passe*</label>
				<input type="password" name="mdpInscri" id="mdpInscri" placeholder="Mot de passe">
				<label for="confMdpInscri">Confirmation du mot de passe*</label>
				<input type="password" name="confMdpInscri" id="confMdpInscri" placeholder="Confirmation mdp">
				<label for="telInscri">Téléphone*</label>
				<input type="text" name="telInscri" id="telInscri" placeholder="01 23 45 67 89">
				<label for="adrInscri">Adresse</label>
				<input type="text" name="adrInscri" id="adrInscri" placeholder="Adresse">
				<label for="villeInscri">Ville</label>
				<input type="text" name="villeInscri" id="villeInscri" placeholder="Ville">
				<label for="cpInscri">Code Postal</label>
				<input type="number" name="cpInscri" id="cpInscri" placeholder="86 400">
				<label for="profInscri">Profession</label>
				<input type="text" name="profInscri" id="profInscri" placeholder="Profession">
				<input type="submit" name="formInscri" class="boutons">
				<!--Affichage d'un message d'erreur-->
				<?php
					if(isset($msgInscri))	{
						echo '<p style="color:red;">'.$msgInscri.'</p>';
					}
				?>
				<!-----------------------------Connection/Recup----------------->
				<div>
					<input type="submit" name="goConnection" class="boutons" value="Se connecter">
					<input type="submit" name="goRecup" class="boutons" value="Mot de passe oublié ?">
				</div>
			</form>
		</section>
	<?php }elseif($section == "recuperation") { ?>
		<!-------ESPACE RECUPERATION MDP------------------------------------------------->
		<section id="recup" class="formulaire">
			<form method="post">
				<h1>Récupération du mot de passe</h1>
				<!--PARTIE DU CODE ENVOYER PAR MAIL-->
				<?php if($partie =='code' ) { ?>
					<p>Veuillez rentrer le code envoyer par mail.<br> (Si le mail n'apparaît pas,<br> vérifiez dans vos spam)</p>
					<input type="text" id="verif_code" name="verif_code" placeholder="Code de vérification"/>
					<?php
						if(isset($msgRecup)) {
							echo '
								<div><p style="color:red;">'.$msgRecup.'</p></div>
							';
						}
					?>
					<input type="submit" name="verif_submit" class="boutons" value="Récupérer"/>
				<!--PARTIE DE LA MODIFICATION DU MOT DE PASSE-->
				<?php } elseif($partie =='changemdp') { ?>
					<p>Nouveau mot de passe pour <?= $_SESSION['recup_mail'] ?></p>
					<input type="password" id="change_mdp" name="change_mdp" placeholder="Nouveau mot de passe"/>
					<input type="password" name="change_mdpc" id="change_mdpc" placeholder="Confirmation du mdp"/>
					<?php
						if(isset($msgRecup)) {
							echo '
								<div><p style="color:red;">'.$msgRecup.'</p></div>
							';
						}
					?>
					<input type="submit" name="change_submit" class="boutons" value="Récupérer"/>	
				<!--PARTIE OU L'UTILISATEUR RENTRE L' @ MAIL-->	
				<?php } else { ?>
					<input type="email" id="recup_mail" name="recup_mail" placeholder="Votre adresse mail"/>
					<?php
						if(isset($msgRecup)) {
							echo '
								<div><p style="color:red;">'.$msgRecup.'</p></div>
							';
						}
					?>
					<input type="submit" name="recup_submit" class="boutons" value="Récupérer"/>
				<?php } ?> 
				<!-----------------------------Inscription/Connection----------------->
				<div>
					<input type="submit" name="goConnection" class="boutons" value="Se connecter">
					<input type="submit" name="goInscri" class="boutons" value="S'inscrire">
				</div>

			</form>
		</section>
	<?php } ?>
	
	<footer><?php require('./libs/footer.php') ?></footer> <!--Partie Footer-->
</body>
</html>
