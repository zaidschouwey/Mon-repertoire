<?php
// Vérifie que tout est bien là
if(isset($_GET["type"]) && isset($_GET["value"]) && isset($_GET["orderby"])){

  // Met les valeurs dans des variables
  $type = $_GET["type"];
  $value = $_GET["value"];
  $orderby = $_GET["orderby"];


  // Remet exactement le même principe que pour la sélection d'un article dans la liste déroulante de la page PCommande
  $pdo = new PDO('mysql:host=localhost;dbname=horaire', "root", "");
  

  // Si le variable la liste déroulante sélectionnée est "motif", va chercher dans la base de données pour afficher la description de l'article
  if($type == "fjour"){
    $_SESSION['fjour'] = $value;
    echo '<input type="date" id="fdate1" name="fdate1"/>';
  }
  if($type == "fdate1"){
    $res = $pdo->query("SELECT $orderby FROM produits WHERE $type='$value'");
    foreach ($res as $key) {
      echo "<option value>".$key."</option>";
    }
  }
  
  $pdo = null;
}
?>
