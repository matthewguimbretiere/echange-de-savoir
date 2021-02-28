<?php
//$bdd = new PDO('mysql:host=mysql-matguimbretiere.alwaysdata.net;dbname=matguimbretiere_appliptut', '206687', 'Mad13Mat29Fla07');
$bdd = new PDO('mysql:host=localhost;dbname=ptut', 'root', '');

$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>