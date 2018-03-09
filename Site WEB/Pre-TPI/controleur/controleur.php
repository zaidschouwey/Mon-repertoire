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
			$resultats = getUser();
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
				require 'vue/vue_definirhoraire.php';
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
		$resultats = getHorairePersonnel();
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
	}
}

//////////////////////////////////////////////////////////////////////////
// Fonction pour demander un échange d'horaire avec une autre personnes
//////////////////////////////////////////////////////////////////////////
function demanderechangehoraire()
{

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
			$users = getUser();
			$resultats = gethoraireglobal();
			require 'vue/vue_horaireglobal.php';
		} else {erreur("Vous n'avez pas les accès.");}
	} else {erreur("Vous n'avez pas les accès.");}
}

//////////////////////////////////////////////////////////////////////////
// Fonction d'affichage d'une erreur donnée
//////////////////////////////////////////////////////////////////////////
function erreur($msgErreur)
{
	require 'vue/vue_erreur.php';
}
?>