<?php
// index.php
// Date de création : 13.02.18
session_start();
require 'controleur/controleur.php';

try
{
	if (isset($_GET['action']))
	{
		// sélection de l'action à réaliser
		$action = $_GET['action'];
		switch ($action)
		{
			// Connexion
            case 'login':
                login();
                break;
                
            // Etablir l'horaire
            case 'etablirhoraire':
            	etablirhoraire();
            	break;

            // Définir l'horaire définit
            case 'definirhoraire':
            	definirhoraire();       
            	break;

            // Page d'échange d'horaires
            case 'echangehoraire':            	
            	echangehoraire();
            	break;
            	
            // Envoi de mail pour l'échange d'horaires 
            case 'demanderechangehoraire':
            	demanderechangehoraire();
            	break;

            // Infirmières disponible pour un échange d'horaires
            case 'infirmieredisponible':
            	infirmieredisponible();
            	break;

            case 'jourtravailinf':
                  jourtravailinf();
                  break;

            // Affichage de l'horaire de toutes les infirmières
            case 'horaireglobal':
            	horaireglobal();
            	break;
            	
            // Confirmation de l'échange via un mail
            case 'confirmationechange':
            	confirmation();
            	break;

            // En cas d'erreur
			default :
				throw new Exception("action non valide");	
		}
			
	}
	else if (isset ($_SESSION['login'])) // Si la personne est déjà connectée
	{
		horairepersonnel(); // Affichage de l'horaire personnel
	}
	else
	{
		accueil(); // affiche par défaut la page d'accueil
	}
}
catch (Exception $e) // En cas d'erreur
{
	erreur($e->getMessage());
}
?>
