<?php
// controleur.php
// Date de création : 13.02.18

require 'modele/modele.php';

// Affichage de la page de login/accueil
function accueil()
{
	require 'vue/vue_accueil.php';
}

// Fonction de login
function login()
{
	if (isset($_POST['flogin']))
	{
		$resultats = getLogin($_POST);
	}
	require 'vue/vue_accueil.php';
}

function horairepersonnel()
{
	$resultats = getHorairePersonnel();
	require 'vue/vue_horairepersonnel.php';
}

function etablirhoraire()
{
	$resultats = getUser();
	require 'vue/vue_definirhoraire.php';
}

function definirhoraire()
{
	sethoraire($_POST);
}

?>