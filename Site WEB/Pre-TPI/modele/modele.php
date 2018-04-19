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
    $login = $post['flogin'];
    $password = $post['fpassword'];

    // Connexion à la BD
	$connexion = getBD();
    // Vérifie que l'utilisateur est dans la table d'utilisateur
	$requete = $connexion->prepare("SELECT * FROM tblutilisateurs WHERE login=? AND password=?");
    $requete->execute(array($login, $password));
    return $requete;
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
    $requete ="SELECT *
                FROM tblutilisateurs 
                WHERE idutilisateur = '".$_SESSION['idutilisateurto']."'";
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
// Récupère l'horaire personnel d'une personne
//////////////////////////////////////////////////////////////////////////
function getHoraireFromNow()
{
    // Connexion à la BD
    $connexion = getBD();
    $user = $_SESSION['idutilisateur'];
    $requete ="SELECT * FROM tblhoraire WHERE (fk_utilisateur = '".$user."') AND (datefin > now() + INTERVAL 30 DAY) ORDER BY datedebut";
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

function getjourtravailinf($post)
{
    // Connexion à la BD
    $connexion = getBD();
    $requete = "SELECT * from tblhoraire WHERE (fk_utilisateur = '".$post['fidutilisateur']."') AND (datefin > now() + INTERVAL 30 DAY) ORDER BY datedebut";
    $_SESSION['idutilisateurto'] = $post['fidutilisateur'];
    $resultats = $connexion->query($requete);
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
    $ligne = $resultats->fetch();
    if($ligne['userto']==$_SESSION['idutilisateur'])
    {
        return $resultats;
    }
}

//////////////////////////////////////////////////////////////////////////
// Ajoute un échange à la table "tblechange"
//////////////////////////////////////////////////////////////////////////
function addechange($post)
{
    // Reconnexion à la BD
    $connexion = getBD();
    $requete="INSERT INTO tblechange VALUES (DEFAULT, '".$_SESSION['idutilisateur']."', '".$_SESSION['idutilisateurto']."','".$_SESSION['jourechange']."', '".$post['fjouruserto']."')";
    $connexion->exec($requete);
}

//////////////////////////////////////////////////////////////////////////
// Effectue l'échange d'horaire qui a été confirmé
//////////////////////////////////////////////////////////////////////////
function setnewhoraire()
{
    $connexion = getBD();
    $requete="SELECT * FROM tblechange WHERE userto = '".$_SESSION['idutilisateur']."'";
    $tblechange = $connexion->query($requete);
    $donneeschange = $tblechange->fetch();

    $dfinuserask = date('Y-m-d', strtotime($donneeschange['jechangeuserask'] . " -1 days"));
    $ddebutuserask = date('Y-m-d', strtotime($donneeschange['jechangeuserask'] . " +1 days"));

    $dfinuserto = date('Y-m-d', strtotime($donneeschange['jechangeuserto'] . " -1 days"));
    $ddebutuserto = date('Y-m-d', strtotime($donneeschange['jechangeuserto'] . " +1 days"));

    // Modification de l'horaire de l'infirmière demandant un échange
    $connexion = getBD();
    $requete="SELECT * FROM tblhoraire WHERE ('".$donneeschange['jechangeuserask']."' BETWEEN datedebut AND datefin) AND (fk_utilisateur='".$donneeschange['userask']."')";
    $tblhoraireuserask = $connexion->query($requete);
    $horaireuserask = $tblhoraireuserask->fetch();

    $connexion = getBD();
    $requete="UPDATE tblhoraire SET datefin='".$dfinuserask."' WHERE idhoraire = '".$horaireuserask['idhoraire']."';";
    $connexion->exec($requete);
    $connexion = getBD();
    $requete="INSERT INTO tblhoraire VALUES (DEFAULT, '".$ddebutuserask."', '".$horaireuserask['datefin']."', '".$donneeschange['userask']."', '".$horaireuserask['fk_plagehoraire']."')";
    $connexion->exec($requete);

    // Modification de l'horaire de l'infirmière recevant la demande
    $connexion = getBD();
    $requete="SELECT * FROM tblhoraire WHERE ('".$donneeschange['jechangeuserto']."' BETWEEN datedebut AND datefin) AND (fk_utilisateur='".$donneeschange['userto']."')";
    $tblhoraireuserto = $connexion->query($requete);
    $horaireuserto = $tblhoraireuserto->fetch();

    $connexion = getBD();
    $requete="UPDATE tblhoraire SET datefin='".$dfinuserto."' WHERE idhoraire = '".$horaireuserto['idhoraire']."';";
    $connexion->exec($requete);
    $connexion = getBD();
    $requete="INSERT INTO tblhoraire VALUES (DEFAULT, '".$ddebutuserto."', '".$horaireuserto['datefin']."', '".$donneeschange['userto']."', '".$horaireuserto['fk_plagehoraire']."')";
    $connexion->exec($requete);


    $connexion = getBD();
    $requete = "INSERT INTO tblhoraire VALUES (DEFAULT, '".$donneeschange['jechangeuserto']."', '".$donneeschange['jechangeuserto']."', '".$donneeschange['userask']."', '".$horaireuserto['fk_plagehoraire']."' ),(DEFAULT, '".$donneeschange['jechangeuserask']."', '".$donneeschange['jechangeuserask']."', '".$donneeschange['userto']."', '".$horaireuserask['fk_plagehoraire']."')";
    $connexion->exec($requete);

    $connexion = getBD();
    $requete="DELETE FROM tblechange WHERE USERTO='".$_SESSION['idutilisateur']."'";
    $connexion->exec($requete);
}