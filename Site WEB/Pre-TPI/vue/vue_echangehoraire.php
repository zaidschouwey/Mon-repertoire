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
  <script type="text/javascript">
    // Fonction pour vérifier qu'AJAX peut être utilisé sur le navigateur
    function get(file, success)
    {
      var xhr = new XMLHttpRequest() || new ActiveXObject("Microsoft.XMLHTTP") || new ActiveXObject("Msxml2.XMLHTTP") || null;
      if (!xhr) {
        return alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
      }

      // On défini ce qu'on va faire quand on aura la réponse
      xhr.onreadystatechange = function(){

        // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
        if(xhr.readyState != 4) return;
        if(xhr.status == 200){
          success(xhr.responseText);
        }
        else {
          // TODO error message
          alert("Error HTTP response !");
        }
      }
      xhr.open("GET", file, true);
      xhr.send();
    }

      // Fonction pour envoyer les infos dans la page AJAX pour les listes déroulantes
      function getListBySource(src, dst){
        var sel = document.getElementById(src);
        var val = sel.options[sel.selectedIndex].value;


        // Envoie à la page AJAX la ce qu'on a sélectionné dans la liste déroulante
        get("vue/vue_echangehoraire_ajax.php/?type=" + src + "&value=" + val + "&orderby=" + dst, function(response)
        {
          document.getElementById(dst).innerHTML = response;
        });
      }

  </script>

  <h2>Echange d'horaire</h2>
  <article>
    <form class="form" method="POST" action="index.php?action=infirmieredisponible">
      <table class="table">
        <tr>
          <td>Jour que vous voulez échanger</td>
            <td><select name="fjour" id="fjour" onclick="getListBySource('fjour', 'fdate1');">
            <?php foreach($jdate1 as $date){ echo "<option value=".$date.">".$date; }
          ?></select>  
          </td>
        </tr>  
        <tr>  
          <td>Jour durant lequel vous pourrez venir travailler</td><td><input onclick="getListBySource('fdate1', 'finfirmieredisponible');" type="date" id='fdate1' name="fdate1"/></td>
        <tr>
         <td><input class="btn" type="submit" value="Voir personnes disponible"/></td>
       </tr>
      </table>
      <select id="finfirmieredisponible">
        
      </select>
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