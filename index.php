<?php
require_once '_inc/functions.php';

$results = find3Rand();

require_once '_inc/header.php';
require_once '_inc/nav.php';
?>

<main>
    <h1>
        Bienvenue a l'accueil
    </h1>
    <?php

    
    foreach($results as $row) {
        echo "Titre: " . $row["title"] . "<br>";
        echo "Affiche: <img src='/img/{$row['poster']}' alt='' width='100px' height='100px'>" . "<br>";
        echo "Prix: " . $row["price"] . "<br>";
        echo "<a href='/game.php?id={$row['id']}'><button>Consulter</button></a><br><br>";
    }
    ?>
</main>

<?php
require_once '_inc/footer.php';
?>
    