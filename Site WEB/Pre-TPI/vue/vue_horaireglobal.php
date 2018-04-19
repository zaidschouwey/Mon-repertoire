<?php
// fichier : vue_horaireglobal.php
// date de création : 09.03.18

$titre = 'Horaire global';

if(!isset($_SESSION['typeutilisateur'])){
  header("location: ../index.php");
}

ob_start();
// Définition des variables
$jtra = 0;
$tbljtra = array();
$jdate1 = array(); 
$list=array();
$month = date('m');
$year = date('Y');
$listmax = 0;
$pla = 1;
// Récupère les jours du mois courant
for($d=1; $d<=31; $d++){
    $time=mktime(12, 0, 0, $month, $d, $year);          
    if (date('m', $time)==$month)       
        $list[]=date('d', $time);
}

// Récupère les jours qui se trouve entre une date début et une date de fin
while ($donnee = $resultats->fetch()){
  if(isset($donnee)){
    $d1 = $donnee['datedebut'];
    $d2 = $donnee['datefin'];
  }
  $nb_jours = date_diff2($d1, $d2);
  $jour_apres = toStamp2($d1)-(60*60*24);
  $monthnum = strtotime($d1) ;
  $monthnum = date('m', $monthnum);
  if ($monthnum==$month) {
    for($i = 0; $i < $nb_jours; $i++){
      $jour_apres += (60*60*24);
      // Récupère la tranche horaire travaillée dans le jour 
      if ($donnee['fk_plagehoraire'] == 1){
        $plage = 'm';
      }
      if ($donnee['fk_plagehoraire'] == 2){
        $plage = 'a';
      }
      if ($donnee['fk_plagehoraire'] == 3){
        $plage = 's';
      }
      if (date('m', $jour_apres)==$month) {
        $jdate1[$donnee['fk_utilisateur']][] = date('d',$jour_apres);
        $jdate1[$donnee['fk_utilisateur']][] = $plage;
      }
    }     
  }  
}
?>
<h2>Horaire Global</h2>
<article>
  <table class="table">
    <thead>
      <tr><td><h3><?php echo date('F'); ?></h3></td></tr>
    </br>
        <tr><td></td>
          <?php 
          // Affiche toutes les dates du mois courant dans le tableau
          foreach($list as $date){ 
            echo "<td>$date"; echo "</td>"; 
          }?>
        </tr>
    </thead>
    <tbody>
    <?php 
    // Affichage des utilisateurs et de leurs horaires
    while($personnel = $users->fetch())  { 
      // Affichage du nom et prénom des utilisateur dans le tableau
      echo "<tr><td>"?><?=$personnel['prenom']?> <?=$personnel['nom']?>
      <?php 
      // Pour le réaffichage des dates d'entête
      $listmax++;
      // Pour la plage horaire travaillée
      $pla = -1;
      // Affichage de l'horaire pour l'utilisateur
      foreach($list as $mdate){
        if(isset($jdate1[$personnel['idutilisateur']])){          
          if(in_array($mdate, $jdate1[$personnel['idutilisateur']])){      
              $pla = $pla+2; 
              if($jdate1[$personnel['idutilisateur']][$pla] == 'm'){
                echo "<td bgcolor='#ffaa00'></td>";  
              }
              if($jdate1[$personnel['idutilisateur']][$pla] == 'a'){
                echo "<td bgcolor='#00ccff'></td>";  
              }
              if($jdate1[$personnel['idutilisateur']][$pla] == 's'){
                echo "<td bgcolor='black'></td>";  
              }                                                                        
          }
          else{
            // Si le jour n'est pas travaillé par la personne
            echo "<td></td>";
          }
        }
        else{
          // Si la personne ne travaille pas durant le mois
          echo "<td></td>";
        }     
      }
      ?>
      </td></tr>  
      <?php 
      // Réaffichage des dates d'entêtes
      if($listmax ==15){ $listmax =0;?>
      <tr><td></td>
          <?php foreach($list as $date){ echo "<td>$date"; echo "</td>"; }?>
        </tr>
      <?php }
    } ?>
    </tbody>
  </table>
  <tfoot>
    <table class="table">
      <thead>
      <tr><td><h4>Légendes : </h4></td></tr>
      </thead>
        <tr>
          <td align="center" bgcolor="#ffaa00"><font color="white">05:00 - 13:45</font></td>
        
          <td align="center" bgcolor="#00ccff"><font color="white">13:15 - 22:00</font></td>
        
          <td align="center" bgcolor="black"><font color="white">21:30 - 05:45</font></td>
        </tr>
        <tr></tr>
    </table>
  </tfoot>
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