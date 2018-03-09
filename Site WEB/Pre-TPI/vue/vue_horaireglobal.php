<?php
// fichier : vue_horaireglobal.php
// date de création : 09.03.18

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
     
        $jdate1[] = date('d', $jour_apres);
        $jdate1[] = $donnee['fk_utilisateur'];
    }       
  }
  print_r($jdate1);

 ?>

  <h2>Horaire Global</h2>

  <article>
    <table class="table">
      <thead>
        <tr><h3><?php echo date('F'); ?></h3></tr>
          <tr><td></td>
            <?php foreach($list as $date){ echo "<td>$date"; echo "</td>"; }?>
          </tr>
      </thead>
      <tbody>
            <?php 
            while($personnel = $users->fetch())  
            { 
              echo "<tr><td value=".$personnel['idutilisateur'].">"?><?=$personnel['prenom']?> <?=$personnel['nom']?>
              <?php 
              $i = 1;
              $d = 0;
              foreach($list as $mdate){
                if($personnel['idutilisateur']==$jdate1[$i])
                {       
                  echo $mdate;
                  
                  if(strcmp($mdate, $jdate1[$d]) == 0)
                  {
                    echo "<td bgcolor='deepskyblue'></td>";
                  }
                  else
                  {
                    echo "<td>d</td>";
                  }
                  var_dump($jdate1[$d]); 
                  $i = $i+2;
                  $d = $d+2;
                }
                else 
                {
                  echo "<td>d</td>";
                }
              }

          ?>



            </td></tr>
            




            <?php } ?>
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