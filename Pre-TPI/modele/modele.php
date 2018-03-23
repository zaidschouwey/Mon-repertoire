<?php 
// modele.php
// Date de création 13.02.18

//////////////////////////////////////////////////////////////////////////
// Connexion à la BD
//////////////////////////////////////////////////////////////////////////
function getBD()
{
	$connexion = new PDO('mysql:host=piui.myd.infomaniak.com; dbname=piui_PreTpi; charset=utf8','piui_DBZaid','MotDePasse!2018');
	return $connexion;
}

//////////////////////////////////////////////////////////////////////////
// Fonction de contrôle de login
//////////////////////////////////////////////////////////////////////////
function getLogin($post)
{
    // Connexion à la BD
	$connexion = getBD();
    // Vérifie que l'utilisateur est dans la table d'utilisateur
	$requete ="SELECT * FROM tblutilisateurs WHERE login='".$post['flogin']."' AND password='".$post['fpassword']."'";
	$resultats = $connexion->query($requete);
	return $resultats;
}

//////////////////////////////////////////////////////////////////////////
// Recupère toutes les infirmières et les responsables
//////////////////////////////////////////////////////////////////////////
function getUsers()
{
    // Connexion à la BD
	$connexion = getBD();
	$requete ="SELECT * FROM tblutilisateurs WHERE fk_typeutilisateur='1' OR fk_typeutilisateur = '2' ORDER BY nom";
	$resultats = $connexion->query($requete);
	return $resultats;
}

//////////////////////////////////////////////////////////////////////////
// Recupère une
//////////////////////////////////////////////////////////////////////////
function getUser($post)
{
    // Connexion à la BD
    $connexion = getBD();
    $requete ="SELECT tblhoraire.idhoraire, tblhoraire.datedebut, tblhoraire.datefin, tblhoraire.fk_utilisateur, tblutilisateurs.nom, tblutilisateurs.prenom, tblutilisateurs.mail, tblhoraire.fk_plagehoraire
                FROM tblhoraire 
                INNER JOIN tblutilisateurs ON tblutilisateurs.idutilisateur = tblhoraire.fk_utilisateur
                WHERE tblhoraire.idhoraire = '".$post['fidhoraire']."'";
    $resultats = $connexion->query($requete);
    return $resultats;
}

//////////////////////////////////////////////////////////////////////////
// Défini un nouvel horaire
//////////////////////////////////////////////////////////////////////////
function sethoraire($post)
{
    // Connexion à la BD
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
    // Connexion à la BD
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
    // Connexion à la BD
    $connexion = getBD();
    $requete = "SELECT tblhoraire.idhoraire, tblhoraire.datedebut, tblhoraire.datefin, tblhoraire.fk_utilisateur, tblutilisateurs.nom, tblutilisateurs.prenom, tblhoraire.fk_plagehoraire FROM tblhoraire INNER JOIN tblutilisateurs ON tblutilisateurs.idutilisateur = tblhoraire.fk_utilisateur WHERE fk_utilisateur NOT IN(SELECT fk_utilisateur FROM tblhoraire WHERE '".$post['fjour']."' BETWEEN datedebut AND datefin) ORDER BY `tblutilisateurs`.`nom` ASC";
    $resultats = $connexion->query($requete);
    $_SESSION['jourechange'] = $post['fjour'];
    return $resultats;

}

//////////////////////////////////////////////////////////////////////////
// Récupère l'horaire de toutes les infirmières
//////////////////////////////////////////////////////////////////////////
function gethoraireglobal()
{
    // Connexion à la BD
    $connexion = getBD();
    $requete ="SELECT tblhoraire.idhoraire, tblhoraire.datedebut, tblhoraire.datefin, tblhoraire.fk_utilisateur, tblutilisateurs.nom, tblutilisateurs.prenom, tblhoraire.fk_plagehoraire
        FROM tblhoraire 
    INNER JOIN tblutilisateurs ON tblutilisateurs.idutilisateur = tblhoraire.fk_utilisateur ORDER BY tblhoraire.datedebut";
    $resultats = $connexion->query($requete);
    return $resultats;
}

//////////////////////////////////////////////////////////////////////////
// Check si un échange d'horaire est en cours
//////////////////////////////////////////////////////////////////////////
function checkechange($post)
{
    // Connexion à la BD
    $connexion=getBD();
    $requete="SELECT * FROM tblechange WHERE userto='".$_SESSION['idutilisateur']."'";
    $resultats = $connexion->query($requete);
    return $resultats;
}

//////////////////////////////////////////////////////////////////////////
// Ajoute un échange à la table "tblechange"
//////////////////////////////////////////////////////////////////////////
function addechange($post)
{
    // Connexion à la BD
    $connexion= getBD();
    $requete ="SELECT fk_utilisateur FROM tblhoraire WHERE idhoraire='".$post['fidhoraire']."'";
    $resultats = $connexion->query($requete);
    $ligne = $resultats->fetch();
    // Reconnexion à la BD
    $connexion = getBD();
    $requete="INSERT INTO tblechange VALUES (DEFAULT, '".$_SESSION['jourechange']."', '".$_SESSION['idutilisateur']."','".$ligne['fk_utilisateur']."','".$post['fidhoraire']."','".$post['fjourdisp']."','".$post['ftranchehoraire']."')";
    $connexion->exec($requete);
}

//////////////////////////////////////////////////////////////////////////
// Effectue l'échange d'horaire qui a été confirmé
//////////////////////////////////////////////////////////////////////////
function setnewhoraire()
{
    // Connexion à la BD
    $connexion = getBD();
    $requete="SELECT * FROM tblechange WHERE USERTO = '".$_SESSION['idutilisateur']."'";
    $resultats = $connexion->query($requete);
    $ligne = $resultats->fetch();
    $datefin = date('Y-m-d', strtotime($ligne['jourechange'] . " -1 days"));
    $datedebut = date('Y-m-d', strtotime($ligne['jourechange'] . " +1 days"));

    // Connexion à la BD
    $connexion = getBD();
    $requete="SELECT * FROM tblhoraire WHERE ('".$ligne['jourechange']."' BETWEEN datedebut AND datefin) AND (fk_utilisateur='".$ligne['userask']."')";
    $resultats1 = $connexion->query($requete);

    // Connexion à la BD
    $connexion = getBD();
    $requete ="SELECT datefin, fk_utilisateur, fk_plagehoraire FROM tblhoraire WHERE idhoraire='".$ligne['usertoidhoraire']."'";
    $resultats2 = $connexion->query($requete);
    $ligne1=$resultats1->fetch();
    $ligne2=$resultats2->fetch();

    // Connexion à la BD
    $connexion = getBD();
    $requete="UPDATE tblhoraire SET datefin='".$datefin."' WHERE idhoraire = '".$ligne1['idhoraire']."';";
    $connexion->exec($requete);

    // Connexion à la BD
    $connexion = getBD();
    $requete="INSERT INTO tblhoraire VALUES (DEFAULT,'".$datedebut."','".$ligne1['datefin']."', '".$ligne['userask']."', '".$ligne1['fk_plagehoraire']."'),(DEFAULT,'".$ligne['jourechange']."','".$ligne['jourechange']."','".$ligne2['fk_utilisateur']."','".$ligne1['fk_plagehoraire']."'),(DEFAULT,'".$ligne['fuseraskjdisp']."','".$ligne['fuseraskjdisp']."','".$ligne['userask']."','".$ligne['userasktranche']."')";
    $connexion->exec($requete);

    $connexion = getBD();
    $requete="DEL FROM tblechange WHERE USERTO='".$_SESSION['idutilisateur']."'";
    $connexion->exec($requete);



    /*
    $datefin = $_SESSION['jourechange'];
    $datedebut = $_SESSION['jourechange'];
    $datefin = date('Y-m-d', strtotime($_SESSION['jourechange'] . " -1 days"));
    $datedebut = date('Y-m-d', strtotime($_SESSION['jourechange'] . " +1 days"));
    $connexion = getBD();
    $requete ="SELECT * FROM tblhoraire WHERE ('".$_SESSION['jourechange']."' BETWEEN datedebut AND datefin) AND (fk_utilisateur='".$_SESSION['idutilisateur']."')";
    $resultats1 = $connexion->query($requete);
    $connexion = getBD();
    $requete ="SELECT datefin, fk_utilisateur, fk_plagehoraire FROM tblhoraire WHERE idhoraire='".$post['fidhoraire']."'";
    $resultats2 = $connexion->query($requete);
    $ligne1=$resultats1->fetch();
    $ligne2=$resultats2->fetch();
    $connexion = getBD();
    $requete="UPDATE tblhoraire SET datefin='".$datefin."' WHERE idhoraire = '".$ligne1['idhoraire']."';";
    $connexion->exec($requete);
    $connexion = getBD();
    $requete="INSERT INTO tblhoraire VALUES (DEFAULT,'".$datedebut."','".$ligne1['datefin']."', '".$_SESSION['idutilisateur']."', '".$ligne1['fk_plagehoraire']."'),(DEFAULT,'".$_SESSION['jourechange']."','".$_SESSION['jourechange']."','".$ligne2['fk_utilisateur']."','".$ligne1['fk_plagehoraire']."'),(DEFAULT,'".$post['fjourdisp']."','".$post['fjourdisp']."','".$_SESSION['idutilisateur']."','".$post['ftranchehoraire']."')";
    $connexion->exec($requete);*/
}