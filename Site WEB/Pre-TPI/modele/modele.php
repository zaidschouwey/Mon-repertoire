<?php 
// modele.php
// Date de création 13.02.18

//////////////////////////////////////////////////////////////////////////
// Connexion à la BD
//////////////////////////////////////////////////////////////////////////
function getBD()
{
	$connexion = new PDO('mysql:host=localhost; dbname=horaire; charset=utf8','root','');
	return $connexion;
}

//////////////////////////////////////////////////////////////////////////
// Fonction de contrôle de login
//////////////////////////////////////////////////////////////////////////
function getLogin($post)
{
	$connexion = getBD();
	$requete ="SELECT * FROM tblutilisateurs WHERE login='".$post['flogin']."' AND password='".$post['fpassword']."'";
	$resultats = $connexion->query($requete);
	return $resultats;
}

//////////////////////////////////////////////////////////////////////////
// Recupère toutes les infirmières et les responsables
//////////////////////////////////////////////////////////////////////////
function getUser()
{
	$connexion = getBD();
	$requete ="SELECT * FROM tblutilisateurs WHERE fk_typeutilisateur='1' OR fk_typeutilisateur = '2'";
	$resultats = $connexion->query($requete);
	return $resultats;
}

//////////////////////////////////////////////////////////////////////////
// Défini un nouvel horaire
//////////////////////////////////////////////////////////////////////////
function sethoraire($post)
{

	$connexion = getBD();
    $requete ="INSERT INTO tblhoraire VALUES (DEFAULT,'".$post['fdatedebut1']."','".$post['fdatefin1']."','".$post['finfirmiere']."','".$post['ftranchehoraire1']."'),(DEFAULT,'".$post['fdatedebut2']."','".$post['fdatefin2']."','".$post['finfirmiere']."','".$post['ftranchehoraire2']."')";
	$connexion->exec($requete);
	return "true";
}

//////////////////////////////////////////////////////////////////////////
// Récupère l'horaire personnel d'une personne
//////////////////////////////////////////////////////////////////////////
function getHorairePersonnel()
{
    $connexion = getBD();
    $user = $_SESSION['idutilisateur'];
    $requete ="SELECT * FROM tblhoraire WHERE fk_utilisateur = '".$user."' ORDER BY datedebut";
    $resultats = $connexion->query($requete);
    return $resultats;
}

//////////////////////////////////////////////////////////////////////////
// Récupère les infirmières disponible pour le jour donné
//////////////////////////////////////////////////////////////////////////
function getinfirmieredisponible($post)
{
    $connexion = getBD();

}

function gethoraireglobal()
{
    $connexion = getBD();
    $requete ="SELECT tblhoraire.idhoraire, tblhoraire.datedebut, tblhoraire.datefin, tblhoraire.fk_utilisateur, tblutilisateurs.nom, tblutilisateurs.prenom, tblhoraire.fk_plagehoraire
        FROM tblhoraire 
    INNER JOIN tblutilisateurs ON tblutilisateurs.idutilisateur = tblhoraire.fk_utilisateur";
    $resultats = $connexion->query($requete);
    return $resultats;
}
