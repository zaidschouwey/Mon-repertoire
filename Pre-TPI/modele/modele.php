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
	$requete ="SELECT * FROM tblutilisateurs WHERE fk_typeutilisateur='1' OR fk_typeutilisateur = '2' ORDER BY nom";
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
    $requete = "SELECT tblhoraire.idhoraire, tblhoraire.datedebut, tblhoraire.datefin, tblhoraire.fk_utilisateur, tblutilisateurs.nom, tblutilisateurs.prenom, tblhoraire.fk_plagehoraire
                FROM tblhoraire 
                INNER JOIN tblutilisateurs ON tblutilisateurs.idutilisateur = tblhoraire.fk_utilisateur
                WHERE ".$post['fjour']."  NOT BETWEEN datedebut AND datefin";
    $resultats = $connexion->query($requete);
    $_SESSION['jourechange'] = $post['fjour'];
    return $resultats;

}

function gethoraireglobal()
{
    $connexion = getBD();
    $requete ="SELECT tblhoraire.idhoraire, tblhoraire.datedebut, tblhoraire.datefin, tblhoraire.fk_utilisateur, tblutilisateurs.nom, tblutilisateurs.prenom, tblhoraire.fk_plagehoraire
        FROM tblhoraire 
    INNER JOIN tblutilisateurs ON tblutilisateurs.idutilisateur = tblhoraire.fk_utilisateur ORDER BY tblhoraire.datedebut";
    $resultats = $connexion->query($requete);
    return $resultats;
}


function setnewhoraire($post)
{
    $datefin = $_SESSION['jourechange'];
    $datedebut = $_SESSION['jourechange'];
    $datefin = date('Y-m-d', strtotime($_SESSION['jourechange'] . " -1 days"));
    $datedebut = date('Y-m-d', strtotime($_SESSION['jourechange'] . " +1 days"));

    echo $post['fidhoraire']."    ";



    $connexion = getBD();
    $requete ="SELECT datefin, fk_utilisateur, fk_plagehoraire FROM tblhoraire WHERE idhoraire='".$post['fidhoraire']."'";
    $resultats = $connexion->query($requete);

    /*
    $connexion = getBD();
    $requete="UPDATE tblhoraire SET datefin='".$datefin."' WHERE idhoraire = '".$post['fidhoraire']."';";
    $connexion->exec($requete);*/

    $ligne=$resultats->fetch();

    echo $datedebut."  ";
    echo $ligne['datefin']."datefin";
    echo $ligne['fk_utilisateur']." ";
    echo $ligne['fk_plagehoraire']." "; 
    echo $_SESSION['idutilisateur']." "; 
    echo $post['ftranchehoraire'];


    /*
    $connexion = getBD();
    $requete="INSERT INTO tblhoraire VALUES (DEFAULT,'".$datedebut."','".$ligne['datefin']."', '".$ligne['fk_utilisateur']."', '".$ligne['fk_plagehoraire']."'),(DEFAULT,'".$_SESSION['jourechange']."','".$_SESSION['jourechange']."','".$_SESSION['idutilisateur']."','".$post['ftranchehoraire']."')";
    $connexion->exec($requete);*/

}