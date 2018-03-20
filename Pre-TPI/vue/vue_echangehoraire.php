<?php
// fichier : vue_echangehoraire.php
// date de création : 08.03.2018
  
  $titre = 'echangehoraire';
  ob_start();
  $list=array();
  $month = date('m');
  $year = date('Y');
  while ($donnee = $resultats->fetch())
  {
    if(isset($donnee)){
      $d1 = $donnee['datedebut'];
      $d2 = $donnee['datefin'];
    }
    $nb_jours = date_diff2($d1, $d2);
    $jour_apres = toStamp2($d1)-(60*60*24);
    for($i = 0; $i < $nb_jours; $i++) 
    {
      $jour_apres += (60*60*24);
      $jdate1[] = date('Y-m-d', $jour_apres);
    }           
  }
  ?>
  <h2>Echange d'horaire</h2>
  <article>
    <form class="form" method="POST" action="index.php?action=infirmieredisponible">
      <table class="table">
        <tr>
          <td>Jour que vous voulez échanger</td>
            <td><select name="fjour">
            <?php foreach($jdate1 as $date){ echo "<option value=".$date.">".$date; }
          ?></select>  
          </td>
        </tr>  
         <td><input class="btn" type="submit" value="Voir personnes disponible"/></td>
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