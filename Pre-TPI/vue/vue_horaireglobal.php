<?php
// fichier : vue_horaireglobal.php
// date de création : 09.03.18

  $titre = 'horairepersonnel';
  
  if(!isset($_SESSION['typeutilisateur'])){
    header("location: ../index.php");
  }

  ob_start();
  $jdate1 = array(); 
  $list=array();
  $month = date('m');
  $year = date('Y');
  $listmax = 0;
  $pla = 1;
  for($d=1; $d<=31; $d++){
      $time=mktime(12, 0, 0, $month, $d, $year);          
      if (date('m', $time)==$month)       
          $list[]=date('d', $time);
  }
  while ($donnee = $resultats->fetch()){
    if(isset($donnee)){
      $d1 = $donnee['datedebut'];
      $d2 = $donnee['datefin'];
    }
    $nb_jours = date_diff2($d1, $d2);
    $jour_apres = toStamp2($d1)-(60*60*24);
    for($i = 0; $i < $nb_jours; $i++){
      $jour_apres += (60*60*24);
      if ($donnee['fk_plagehoraire'] == 1){
        $plage = 'm';
      }
      if ($donnee['fk_plagehoraire'] == 2){
        $plage = 'a';
      }
      if ($donnee['fk_plagehoraire'] == 3){
        $plage = 's';
      }
      $jdate1[$donnee['fk_utilisateur']][] = date('d',$jour_apres);
      $jdate1[$donnee['fk_utilisateur']][] = $plage;
    }       
  }
 ?>
  <h2>Horaire Global</h2>
  <article>
    <table class="table">
      <thead>
        <tr>
          <td>05:00 - 13:45 =</td><td bgcolor="#ffaa00"></td>
        </tr>
        <tr>
          <td>13:15 - 22:00 =</td><td bgcolor="#00ccff"></td>
        </tr>
        <tr>
          <td>21:30 - 05:45 =</td><td bgcolor="black"></td>
        </tr>
        <tr></tr>
        <tr><td><h3><?php echo date('F'); ?></h3></td></tr>
      </br>
          <tr><td></td>
            <?php foreach($list as $date){ echo "<td>$date"; echo "</td>"; }?>
          </tr>
      </thead>
      <tbody>
      <?php 
      while($personnel = $users->fetch())  { 
        echo "<tr><td>"?><?=$personnel['prenom']?> <?=$personnel['nom']?>
        <?php 
        $listmax++;
        $pla = -1;
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
              echo "<td></td>";
            }
          }
          else{
            echo "<td></td>";
          }     
        }
        ?>
        </td></tr>  
        <?php 
        if($listmax ==15){ $listmax =0;?>
        <tr><td></td>
            <?php foreach($list as $date){ echo "<td>$date"; echo "</td>"; }?>
          </tr>
        <?php }
      } ?>
      </tbody>
    </table>
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