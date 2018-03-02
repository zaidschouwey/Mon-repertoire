<?php 
// modele.php
// Date de création 13.02.18

// Connexion à la BD
function getBD()
{
	$connexion = new PDO('mysql:host=localhost; dbname=horaire; charset=utf8','root','');
	//$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERMODE_EXCEPTION);
	return $connexion;
}

// Fonction de contrôle de login
function getLogin($post)
{
	$connexion = getBD();
	$requete ="SELECT * FROM tblutilisateurs WHERE login='".$post['flogin']."' AND password='".$post['fpassword']."'";
	$resultats = $connexion->query($requete);
	return $resultats;
}

// Recupère toutes les infirmières et les responsables
function getUser()
{
	$connexion = getBD();
	$requete ="SELECT * FROM tblutilisateurs WHERE fk_typeutilisateur='1' OR fk_typeutilisateur = '2'";
	$resultats = $connexion->query($requete);
	return $resultats;
}

function sethoraire($post)
{

	$connexion = getBD();
    $requete ="INSERT INTO tblhoraire VALUES (DEFAULT,'".$post['fdatedebut1']."','".$post['fdatefin1']."','".$post['finfirmiere']."','".$post['ftranchehoraire1']."'),(DEFAULT,'".$post['fdatedebut2']."','".$post['fdatefin2']."','".$post['finfirmiere']."','".$post['ftranchehoraire2']."')";
	$connexion->exec($requete);
	return "true";
}

function getHorairePersonnel()
{
    $connexion = getBD();
    $user = $_SESSION['idutilisateur'];
    echo $user;
    $requete ="SELECT * FROM tblhoraire WHERE fk_utilisateur = '".$user."'";
    $resultats = $connexion->query($requete);
    return $resultats;
}


