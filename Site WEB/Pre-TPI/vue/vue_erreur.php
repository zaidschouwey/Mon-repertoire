<?php 
// fichier : vue_erreur.php
// date de création : 22.03.18
$titre = 'Erreur';
ob_start() ?>
<p>Une erreur est survenue : <?= $msgErreur ?></p>
<?php $contenu = ob_get_clean();
require 'gabarit.php'; ?>