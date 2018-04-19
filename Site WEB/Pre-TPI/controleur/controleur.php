<?php
// controleur.php
// Date de création : 13.02.18

require 'modele/modele.php';

//////////////////////////////////////////////////////////////////////////
// Affichage de la page de login/accueil
//////////////////////////////////////////////////////////////////////////
function accueil()
{
	require 'vue/vue_accueil.php';
}

//////////////////////////////////////////////////////////////////////////
// Fonction de login
//////////////////////////////////////////////////////////////////////////
function login()
{
	if (isset($_POST['flogin']))
	{
		$resultats = getLogin($_POST);
	}
	require 'vue/vue_accueil.php';
}

//////////////////////////////////////////////////////////////////////////
// Fonction d'affichage de l'horaire personnel
//////////////////////////////////////////////////////////////////////////
function horairepersonnel()
{
	if(isset($_SESSION['typeutilisateur'])){
		$resultats = getHorairePersonnel();
		require 'vue/vue_horairepersonnel.php';
	} else {erreur("Vous n'avez pas les accès.");}
	
}

//////////////////////////////////////////////////////////////////////////
// Fonction pour afficher la page "Définir horaire"
//////////////////////////////////////////////////////////////////////////
function etablirhoraire()
{	
	if(isset($_SESSION['typeutilisateur'])){
		if($_SESSION['typeutilisateur'] == 2){
			$resultats = getUsers();
			require 'vue/vue_definirhoraire.php';
		} else {erreur("Vous n'avez pas les accès.");}
	} else {erreur("Vous n'avez pas les accès.");}
}

//////////////////////////////////////////////////////////////////////////
// Fonction pour définir un horaire
//////////////////////////////////////////////////////////////////////////
function definirhoraire()
{
	if(isset($_SESSION['typeutilisateur'])){
		if($_SESSION['typeutilisateur'] == 2){
			if(isset($_POST)){
				sethoraire($_POST);
				header("location:index.php?action=etablirhoraire");
			}
		} else {erreur("Vous n'avez pas les accès.");}
	} else {erreur("Vous n'avez pas les accès.");}
}

//////////////////////////////////////////////////////////////////////////
// Fonction d'affichage de la page "Echange d'horaire"
//////////////////////////////////////////////////////////////////////////
function echangehoraire()
{
	if(isset($_SESSION['typeutilisateur'])){
		$resultats = getHoraireFromNow();
		$form = 1;
		require 'vue/vue_echangehoraire.php';
	} else {erreur("Vous n'avez pas les accès.");}
	
}

//////////////////////////////////////////////////////////////////////////
// Fonction de récupération des infirmières disponibles
//////////////////////////////////////////////////////////////////////////
function infirmieredisponible()
{
	if(isset($_SESSION['typeutilisateur']))
	{
		$resultats = getinfirmieredisponible($_POST);
		$_SESSION['fjour'] = $_POST['fjour'];
		$form = 2;
		require 'vue/vue_echangehoraire.php';
	} else {erreur("Vous n'avez pas les accès.");}
}

function jourtravailinf()
{
	$resultats = getjourtravailinf($_POST);
	$user = getUser($_POST);
	$form = 3;
	require 'vue/vue_echangehoraire.php';
}

//////////////////////////////////////////////////////////////////////////
// Fonction pour demander un échange d'horaire avec une autre personne
//////////////////////////////////////////////////////////////////////////
function demanderechangehoraire()
{
	if(isset($_SESSION['typeutilisateur']))
	{
		$resultats = getUser($_POST);
		addechange($_POST);
		$_SESSION['fjouruserto'] = $_POST['fjouruserto'];
		require 'vue/vue_envoimail.php';
	} else {erreur("Vous n'avez pas les accès.");}
}

//////////////////////////////////////////////////////////////////////////
// Fonction d'affichage de l'horaire global
//////////////////////////////////////////////////////////////////////////
function horaireglobal()
{
	if(isset($_SESSION['typeutilisateur']))
	{
		if($_SESSION['typeutilisateur'] == 2)
		{
			$users = getUsers();
			$resultats = gethoraireglobal();
			require 'vue/vue_horaireglobal.php';
		} else {erreur("Vous n'avez pas les accès.");}
	} else {erreur("Vous n'avez pas les accès.");}
}

//////////////////////////////////////////////////////////////////////////
// Effectue l'échange d'horaire qui a été confirmé
//////////////////////////////////////////////////////////////////////////
function confirmation()
{
	$resultats = checkechange($_SESSION['idutilisateur']);
	if(isset($resultats)){
		setnewhoraire();
		header("location:index.php");
	}else {
		erreur("La confirmation n'a pas pu être vérifiée");
	}
}

//////////////////////////////////////////////////////////////////////////
// Fonction d'affichage d'une erreur donnée
//////////////////////////////////////////////////////////////////////////
function erreur($msgErreur)
{
	require 'vue/vue_erreur.php';
}
?>