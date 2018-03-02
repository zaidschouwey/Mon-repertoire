<?php
// fichier : accueil.php
// date de création : 25.05.16

  $titre = 'Accueil';
  
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

  $ligne=$resultats->fetch();
  print_r($ligne);
 ?>
  <h2>Votre horaire</h2>

  <article>
    <table class="table">
      <thead>
        <tr><h3><?php echo date('F'); ?></h3></tr>
          <tr><td></td>
            <?php foreach($list as $ligne){ echo "<td>$ligne"; echo "</td>"; }?>
          </tr>
      </thead>
      <tbody>
        <tr>
          <td bgcolor="yellow">5:00 - 13:45</td>
        </tr>
        <tr>
          <td>13:15 - 22:00</td>
        </tr>
        <tr>
          <td>21:30 - 5:45</td>
        </tr>
      </tbody>
    </table>
  <article>
<?php 
  $contenu = ob_get_clean(); 
  require 'gabarit.php'; 
?>  