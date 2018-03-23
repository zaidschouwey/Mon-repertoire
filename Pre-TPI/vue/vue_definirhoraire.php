  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <!--Fonction calendrier-->   
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>

  </script>
  </head>

  <?php
  // fichier : vue_definirhor.php
  // date de création : -
  $titre = 'Accueil';
  ob_start();
  ?>

  <h2>Etablir un horaire</h2>
  
  <article>
    <form class="form" method="POST" action="index.php?action=definirhoraire">
      <table class="table">
        <tr>
          <td>
            <select name="finfirmiere" required>
              <?php while($personnel = $resultats->fetch())  { echo "<option value=".$personnel['idutilisateur'].">"?><?=$personnel['prenom']?> <?=$personnel['nom']?>
              </option>
              <?php } ?>
            </select>
          </td>
        </tr>  
        <tr>  
          <td>Date</td><td>début :</td><td><input required type="date" id="datepicker_debut1" name="fdatedebut1" onchange="var input = document.getElementById('datepicker_fin1');
    input.setAttribute('min', this.value);"></td>
          <td>Date</td><td>début :</td><td><input  type="date" id="datepicker_debut2" name="fdatedebut2" onchange="var input = document.getElementById('datepicker_fin2');
    input.setAttribute('min', this.value);"></td>
        </tr>
        <tr>
          <td></td><td>fin :</td><td><input required type="date" id="datepicker_fin1" name="fdatefin1"></td>
          <td></td><td>fin :</td><td><input type="date" id="datepicker_fin2" name="fdatefin2"></td>
        </tr>
        <tr>  
          <td></td><td>Tranche horaire :</td><td>
            <select name="ftranchehoraire1">
              <option value="1">05:00 - 13:45</option>
              <option value="2">13:15 - 22:00</option>
              <option value="3">21:30 - 05:45</option>
          </select></td>

          <td></td><td>Tranche horaire :</td><td>
            <select required name="ftranchehoraire2">
              <option value="1">05:00 - 13:45</option>
              <option value="2">13:15 - 22:00</option>
              <option value="3">21:30 - 05:45</option>
          </select></td>
        </tr>

       <tr>
         <td><input class="btn" type="submit" value="Définir l'horaire"/></td>
       </tr>
      </table>
    </form>
  <article>
<?php 
  $contenu = ob_get_clean(); 
  require 'gabarit.php'; 
?>  