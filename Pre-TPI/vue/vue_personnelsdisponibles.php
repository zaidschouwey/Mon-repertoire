<?php
// fichier : vue_personnelsdisponibles.php
// date de création : 16.03.2018
  
  $titre = 'echangehoraire';
  ob_start();
  $list=array();
  $month = date('m');
  $year = date('Y');

  ?>

  <h2>Personnels disponible pour un échange</h2>
  <article>
    <form class="form" method="POST" action="index.php?action=definirechangehoraire">
      <table class="table">
        <tr>
          <td>Infirmière pouvant effectuer un échange : </td>
            <td><select name="fidhoraire">
            <?php foreach($resultats as $ligne){ echo "<option value=".$ligne['idhoraire'].">".$ligne['prenom']." ".$ligne['nom']." -> Tranche horaire :".$ligne['fk_plagehoraire']; }
          ?></select>  
          </td>
        </tr>  
        <tr>  
          <td>Jour durant lequel vous pourrez venir travailler</td><td><input type="date" name="fjourdisp"/></td>
        </tr>
        <tr>  
         <td>Tranches d'heures :</td><td>
            <select name="ftranchehoraire">
              <option value="1">05:00 - 13:45</option>
              <option value="2">13:15 - 22:00</option>
              <option value="3">21:30 - 05:45</option>
          </select></td>
        </tr>
        <tr>
         <td><input class="btn" type="submit" value="Envoyer un mail de demande d'échange"/></td>
       </tr>
      </table>
    </form>
  <article>
  <?php 

  // convertit les dates SQL aaaa-mm-jj en timestamp
  function toStamp2($date) {
  $d = explode('-', $date);
  $date2 = mktime(0,0,0, $d[1], $d[2], $d[0]);
  return $date2;
  }
   
  // compte le nombre de jours entre deux dates SQL aaaa-mm-jj
  function date_diff2($date1, $date2) {
  $s = strtotime($date2)-strtotime($date1);
  $d = intval($s/86400)+1;
  return $d;
  }
  $contenu = ob_get_clean(); 
  require 'gabarit.php'; 
?>  