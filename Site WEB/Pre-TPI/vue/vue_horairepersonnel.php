<?php
// fichier : vue_horairepersonnel.php
// date de création : -

  $titre = 'horairepersonnel';
  
  if(!isset($_SESSION['typeutilisateur']))
  {
    header("location: ../index.php");
  }

  ob_start();
  $list=array();
  $month = date('m');
  $year = date('Y');
  for($d=1; $d<=31; $d++)
  {
      $time=mktime(12, 0, 0, $month, $d, $year);          
      if (date('m', $time)==$month)       
          $list[]=date('d', $time);
  }
  
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
 ?>
  <h2>Votre horaire</h2>

  <article>
    <table class="table">
      <thead>
        <tr><h3><?php echo date('F'); ?></h3></tr>
          <tr><td></td>
            <?php foreach($list as $date){ echo "<td>$date"; echo "</td>"; }?>
          </tr>
      </thead>
      <tbody>
        <tr>
          <td>5:00 - 13:45</td>
          <?php foreach($list as $mdate){
            if(isset($jdate1)){
              if(in_array($mdate, $jdate1)){
              echo "<td bgcolor='deepskyblue'></td>";
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
          <?php foreach($list as $mdate){
            if(isset($jdate2)){
              if(in_array($mdate, $jdate2)){
                echo "<td bgcolor='deepskyblue'></td>";
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
          <?php foreach($list as $mdate){
            if(isset($jdate3)){
              if(in_array($mdate, $jdate3)){
                echo "<td bgcolor='deepskyblue'></td>";
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