<?php 
$titre = 'Erreur';
ob_start() ?>
<p>Une erreur est survenue : <?= $msgErreur ?></p>
<?php $contenu = ob_get_clean();
require 'gabarit.php'; ?>