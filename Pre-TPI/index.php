<?php
// index.php
// date de création : 13.02.18
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
            case 'login':
                login();
                break;
                
            case 'etablirhoraire':
            	etablirhoraire();
            	break;

            case 'definirhoraire':
            	definirhoraire();       
            	break;

            case 'echangehoraire':            	
            	echangehoraire();
            	break;
            	
            case 'demanderechangehoraire':
            	demanderechangehoraire();
            	break;

            case 'infirmieredisponible':
            	infirmieredisponible();
            	break;

            case 'horaireglobal':
            	horaireglobal();
            	break;
            	
            case 'confirmationechange':
            	confirmation();
            	break;

			default :
				throw new Exception("action non valide");	
		}
			
	}
	else if (isset ($_SESSION['login']))
	{
		horairepersonnel();
	}
	else
	{
		accueil(); // affiche par défaut la page d'accueil
	}
}
catch (Exception $e)
{
	erreur($e->getMessage());
}
?>
