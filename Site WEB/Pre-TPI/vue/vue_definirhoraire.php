<meta http-equiv="content-type" content="text/html; charset=utf-8" />
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
            <select name="finfirmiere">
              <?php while($personnel = $resultats->fetch())  { echo "<option value=".$personnel['idutilisateur'].">"?><?=$personnel['prenom']?> <?=$personnel['nom']?>
              </option>
              <?php } ?>
            </select>
          </td>
        </tr>  
        <tr>  
          <td>Date</td><td>début :</td><td><input type="date" name="fdatedebut1"></td>
          <td>Date</td><td>début :</td><td><input type="date" name="fdatedebut2"></td>
        </tr>
        <tr>
          <td></td><td>fin :</td><td><input type="date" name="fdatefin1"></td>
          <td></td><td>fin :</td><td><input type="date" name="fdatefin2"></td>
        </tr>
        <tr>  
          <td></td><td>Matin :</td><td>
            <select name="ftranchehoraire1">
              <option value="1">05:00 - 13:45</option>
              <option value="2">13:15 - 22:00</option>
              <option value="3">21:30 - 05:45</option>
          </select></td>

          <td></td><td>Matin :</td><td>
            <select name="ftranchehoraire2">
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