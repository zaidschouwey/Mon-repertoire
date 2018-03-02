<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php
// fichier : accueil.php
// date de création : 25.05.16
  
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
            <select name="fheuredebut1">
            <?php
            
            for ($i = 00; $i < 24; $i++){
            echo "<option value='".$i.":00'>".$i.":00</option>";
            echo "<option value='".$i.":15'>".$i.":15</option>";
            echo "<option value='".$i.":30'>".$i.":30</option>";
            echo "<option value='".$i.":45'>".$i.":45</option>";
          
          }?>
          </select></td>

          <td></td><td>Matin :</td><td>
            <select name="fheuredebut2">
            <?php
            
            for ($i = 00; $i < 24; $i++){
            echo "<option value='".$i.":00'>".$i.":00</option>";
            echo "<option value='".$i.":15'>".$i.":15</option>";
            echo "<option value='".$i.":30'>".$i.":30</option>";
            echo "<option value='".$i.":45'>".$i.":45</option>";
          
          }?>
          </select></td>
        </tr>
        <tr>
          <td></td><td>Après-midi :</td><td>
            <select name="fheurefin1">
            <?php
            
            for ($i = 00; $i < 24; $i++){
            echo "<option value='".$i.":00'>".$i.":00</option>";
            echo "<option value='".$i.":15'>".$i.":15</option>";
            echo "<option value='".$i.":30'>".$i.":30</option>";
            echo "<option value='".$i.":45'>".$i.":45</option>";
          
          }?>
          </select></td>
          <td></td><td>Après-midi :</td><td>
            <select name="fheurefin2">
            <?php
            
            for ($i = 00; $i < 24; $i++){
            echo "<option value='".$i.":00'>".$i.":00</option>";
            echo "<option value='".$i.":15'>".$i.":15</option>";
            echo "<option value='".$i.":30'>".$i.":30</option>";
            echo "<option value='".$i.":45'>".$i.":45</option>";
          
          }?>
          </select></td>
        </tr>
       <tr>
         <td><input class="btn" type="submit" value="Définir l'horaire" /></td>
       </tr>
      </table>
    </form>
  <article>
<?php 
  $contenu = ob_get_clean(); 
  require 'gabarit.php'; 
?>  