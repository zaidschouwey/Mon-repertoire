<?php
// fichier : vue_envoimail.php
// date de création : 22.03.18
  
$titre = 'Envoi de mail';
ob_start();
// Récupération des variables nécessaires au mail de confirmation	
$ligne = $resultats->fetch();
$email = $ligne['mail'];



 
// Préparation du mail contenant le lien d'activation
$destinataire = $email;
$sujet = "Demande d'échange d'horaires" ;
$entete = "From: SiteEchangeHoraire@hotmail.com" ;
$message = "Bonjour,
 
Voici une demande d'échange d'horaire qui vous a été proposé par : ".$_SESSION['prenom']." ".$_SESSION['nom']."

Jour durant lequel vous devriez venir travailler à sa place : ".$_SESSION['jourechange']."

Jour durant lequel ".$_SESSION['prenom']." ".$_SESSION['nom']." viendrait travailler à votre place : ".$_SESSION['fjouruserto']."

Si vous acceptez, merci de cliquer sur le lien ci-dessous ou de le copier dans votre navigateur :
http://reliability.agency/index.php?action=confirmationechange


 
------------------------------------------------------------------------------------
Ceci est un mail automatique, Merci de ne pas y répondre.";
 

mail($destinataire, $sujet, $message, $entete) ; // Envoi du mail 
echo "<h1>Envoi d'une demande</h1>";
echo "<p>Le mail à été envoyé à ".$email." avec succès.</p>";?>
<meta http-equiv="refresh" content="2;url=index.php" /><?php



$contenu = ob_get_clean(); 
require 'gabarit.php'; 
?>