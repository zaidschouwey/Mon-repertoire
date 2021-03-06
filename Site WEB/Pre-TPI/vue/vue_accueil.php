<?php
// fichier : accueil.php
// date de création : 25.05.16
$titre = 'Accueil';
ob_start(); ?>
<h2>Connexion</h2>
<article>
  <?php
  // Contrôle si l'utilisateur est connecté
  if (isset($resultats)) 
  { 
    // les données dans le formulaire sont exactes
    $ligne=$resultats->fetch();
    if (isset($ligne['prenom']))
    {
      echo "Bonjour ".$ligne['prenom']." ".$ligne['nom'].". Vous êtes connecté."; 
      // Création de la session
      $_SESSION['idutilisateur']=$ligne['idutilisateur'];
      $_SESSION['login']=$ligne['login'];
      $_SESSION['typeutilisateur']=$ligne['fk_typeutilisateur'];
      $_SESSION['nom']=$ligne['nom'];
      $_SESSION['prenom']=$ligne['prenom'];
      ?> <meta http-equiv="refresh" content="2;url=index.php" /><?php
    }
    else
    {
        // Si il y a une erreur dans la connexion, renvoie le formulaire de connexion
        echo "Erreur de login";
        ?> <meta http-equiv="refresh" content="2;url=index.php" /><?php
    }
  } 
  else 
  { 
    // Déconnexion de l'utilisateur s'il presse sur le bouton de déconnexion et renvoie à la page de connexion
    if (isset($_SESSION['login']))
    {
      session_destroy();
      header ("location:index.php");
    }?>
  <form class="form" method="POST" action="index.php?action=login">
    <table class="table">
      <tr>
        <td>Identifiant : </td><td><input type="text" placeholder="Entrez votre login" name="flogin" value="<?= @$_POST['fLogin']; // Evite à l'utilisateur de retaper son login ?>" /><td>
      </tr>  
      <tr>  
        <td>Mot de passe : </td><td><input type="password" placeholder="Entrez votre password" name="fpassword" /></td>
      </tr>
      <tr>  
        <td><input class="btn" type="submit" value="login" />
        </td>
      </tr>
    </table>
  </form>
  <?php } ?>    
<article>
<?php 
$contenu = ob_get_clean(); 
require 'gabarit.php'; 
?>  