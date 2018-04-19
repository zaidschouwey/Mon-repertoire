<?php
// fichier : vue_horairepersonnel.php
// date de création : -

$titre = 'Horaire personnel';

if(!isset($_SESSION['typeutilisateur'])){
  header("location: ../index.php");
}

ob_start();
// Définition des variables
$list=array();
$listaft=array();
$month = date('m');
$monthafter = strtotime ( '+1 month' , strtotime ( date('F') ) ) ;
$monthafter = date('F', $monthafter);
$monthafternum = strtotime ( '+1 month' , strtotime ( date('F') ) ) ;
$monthafternum = date('m', $monthafternum);
$year = date('Y');
// Récupère les jours du mois courant et du mois suivant
for($d=1; $d<=31; $d++)
{
    $time=mktime(12, 0, 0, $month, $d, $year);          
    if (date('m', $time)==$month)       
      $list[]=date('d', $time);
    $timeaft=mktime(12, 0, 0, $monthafternum, $d, $year); 
    if (date('m', $timeaft)==$monthafternum)       
      $listaft[]=date('d', $timeaft);
}

// Récupère les jours qui se trouve entre une date début et une date de fin
while ($donnee = $resultats->fetch())
{
  if(isset($donnee)){
    $d1 = $donnee['datedebut'];
    $d2 = $donnee['datefin'];
  }
  $nb_jours = date_diff2($d1, $d2);  
  $jour_apres = toStamp2($d1)-(60*60*24);
  $monthnum = strtotime($d1) ;
  $monthnum = date('m', $monthnum);
  // Définit un tableau avec les jours/tranche d'horaire travaillé pour le mois courant
  if ($monthnum==$month) {
    for($i = 0; $i < $nb_jours; $i++) 
    {
      $jour_apres += (60*60*24);
      if ($donnee['fk_plagehoraire']==1){
        $jdate1[] = date('d', $jour_apres);
      }
      elseif ($donnee['fk_plagehoraire']==2){
        $jdate2[] = date('d', $jour_apres);
      }
      elseif ($donnee['fk_plagehoraire']==3){
        $jdate3[] = date('d', $jour_apres);
      }
    } 
    
  }
  // Définit un tableau avec les jours/tranche d'horaire travaillé pour le mois suivant
  if ($monthnum==$monthafternum) {
      for($i = 0; $i < $nb_jours; $i++) 
      {
        $jour_apres += (60*60*24);
        if ($donnee['fk_plagehoraire']==1){
          $jdateaft1[] = date('d', $jour_apres);
        }
        elseif ($donnee['fk_plagehoraire']==2){
          $jdateaft2[] = date('d', $jour_apres);
        }
        elseif ($donnee['fk_plagehoraire']==3){
          $jdateaft3[] = date('d', $jour_apres);
        }
      }  
    } 
}

?>
<h2>Votre horaire</h2>

<article>
  <table class="table">
    <thead><tr><td><h3><?php echo date('F'); ?></h3></td></tr></thead>
      <tbody>
        <tr><td></td><?php foreach($list as $date){ echo "<td>$date"; echo "</td>"; } // Affiche toutes les dates du mois courant dans le tableau ?></tr>
        <tr>
        <td>5:00 - 13:45</td>
        <?php foreach($list as $mdate){ // Affichage de l'horaire du mois pour la tranche horaire 05:00 - 13:45
          if(isset($jdate1)){
            if(in_array($mdate, $jdate1)){
            echo "<td bgcolor='#ffaa00'></td>";
            }
            else{
              echo "<td></td>";
            }
          } else {
            echo "<td></td>";
          }
        }?>
        </tr>
        <tr>
          <td>13:15 - 22:00</td>
          <?php foreach($list as $mdate){ // Affichage de l'horaire du mois pour la tranche horaire 13:15 - 22:00
            if(isset($jdate2)){
              if(in_array($mdate, $jdate2)){
                echo "<td bgcolor='#00ccff'></td>";
              }
              else{
                echo "<td></td>";
              }
            } else {
              echo "<td></td>";
            }
          }?>
        </tr>
        <tr>
          <td>21:30 - 5:45</td>
          <?php foreach($list as $mdate){ // Affichage de l'horaire du mois pour la tranche horaire 21:30 - 05:45
            if(isset($jdate3)){
              if(in_array($mdate, $jdate3)){
                echo "<td bgcolor='black'></td>";
              }
              else{
                echo "<td></td>";
              } 
            } else {
              echo "<td></td>";
            }
          }?>
        </tr>
      </tbody>
    </table>


    <table class="table">
      <thead><tr><td><h3><?php echo $monthafter; ?></h3></td></tr></thead>
        <tbody>
        <tr><td></td>
          <?php foreach($listaft as $date){ echo "<td>$date"; echo "</td>"; }?>
        </tr>
   
    
      <tr>
        <td>5:00 - 13:45</td>
        <?php foreach($listaft as $mdate){ // Affichage de l'horaire du mois suivant pour la tranche horaire 05:00 - 13:45
          if(isset($jdateaft1)){
            if(in_array($mdate, $jdateaft1)){
            echo "<td bgcolor='#ffaa00'></td>";
            }
            else{
              echo "<td></td>";
            }
          } else {
            echo "<td></td>";
          }
          
        }?>
      </tr>
      <tr>
        <td>13:15 - 22:00</td>
        <?php foreach($listaft as $mdate){ // Affichage de l'horaire du mois suivant pour la tranche horaire 13:15 - 22:00
          if(isset($jdateaft2)){
            if(in_array($mdate, $jdateaft2)){
              echo "<td bgcolor='#00ccff'></td>";
            }
            else{
              echo "<td></td>";
            }
          } else {
            echo "<td></td>";
          }
        }?>
      </tr>
      <tr>
        <td>21:30 - 5:45</td>
        <?php foreach($listaft as $mdate){ // Affichage de l'horaire du mois pour la tranche horaire 21:30 - 05:45
          if(isset($jdateaft3)){
            if(in_array($mdate, $jdateaft3)){
              echo "<td bgcolor='black'></td>";
            }
            else{
              echo "<td></td>";
            } 
          } else {
            echo "<td></td>";
          }
        }?>
      </tr>
    </tbody>
  </table>
  <a href="index.php?action=echangehoraire">Echange d'horaire</a>
<article>
<?php
// convertit les dates SQL aaaa-mm-jj en timestamp
function toStamp2($ddate) {
  $d = explode('-', $ddate);
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