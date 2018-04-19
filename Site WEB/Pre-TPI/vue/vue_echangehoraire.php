<?php
// fichier : vue_echangehoraire.php
// date de création : 08.03.2018
  
$titre = "Echange d'horaire";
ob_start();
$list=array();
$month = date('m');
$year = date('Y');
// Contrôle sur quel formulaire l'utilisateur se trouve
if (($form==1)||($form==3)){
  // Récupère les jours qui se trouve entre une date début et une date de fin
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
}
?>
<h2>Echange d'horaire</h2>
<article>
  <form class="form" method="POST" action="<?php if ($form == 1){ echo 'index.php?action=infirmieredisponible'; } else if ($form == 2){ echo 'index.php?action=jourtravailinf';} else if ($form == 3){ echo 'index.php?action=demanderechangehoraire';}?>">
    <table class="table">
      <tr>
        <td>Jour que vous voulez échanger :</td>
          <td><?php if ($form==1){ echo "<select name='fjour' required>"; foreach($jdate1 as $date){ echo "<option value=".$date.">".$date; } echo "</select>";} else if ($form!=1){ echo $_SESSION['fjour']; }?>
        </td>
      </tr>   
      <?php if($form ==2){ ?>
        <tr>
          <td>Infirmière pouvant effectuer un échange : </td>
            <td><select name="fidutilisateur" required>
            <?php foreach($resultats as $ligne){ echo "<option value=".$ligne['fk_utilisateur'].">".$ligne['prenom']." ".$ligne['nom']." -> Tranche horaire :".$ligne['fk_plagehoraire']; }
          ?></select>  
          </td>
        </tr> 
      <?php } ?>
      <?php if($form == 3){?>
        <tr>
          <?php $inf = $user->fetch(); ?>
          <td>Jour ou vous pourez venir travailler à la place de <b><?php echo $inf['prenom']." ".$inf['nom'];?></b> : </td><td><?php echo "<select name='fjouruserto' required>"; foreach($jdate1 as $date){ echo "<option value=".$date.">".$date; } echo "</select>"; ?></td>
        </tr>
      <?php }?>
       <td><input class="btn" type="submit" value="<?php if ($form != 3){ echo 'Suivant';} else { echo 'Envoyer demande'; } ?>"/></td>
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