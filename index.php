<?php
require_once '_inc/functions.php';
require_once '_inc/header.php';
require_once '_inc/nav.php';
?>

<main>
    <h1>
        Bienvenue a l'accueil
    </h1>
</main>

<?php
findAll();
findOneBy(1);
find3Rand();

require_once '_inc/footer.php';
?>
    