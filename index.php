<?php

session_start();

require_once '_inc/functions.php';

$results = find3Rand();

require_once '_inc/header.php';
require_once '_inc/nav.php';

 $message = getSessionFlashMessage('notice');
 echo $message;

?>

<main>
    <h1>
        Bienvenue a l'accueil
    </h1>

<table class="table sortable" style="width:100%">
        <thead>
            <tr>
                <th>Titre</td>
                <th>Poster</th>
                <th>Prix</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($results as $row) {
                echo "<tr><td>" . $row["title"] . "</td>";
                echo "<td><img src='/img/{$row['poster']}' alt='' width='100px' height='100px'>" . "</td>";
                echo "<td>" . $row["price"] . "</td>";
                echo "<td><a href='/game.php?id={$row['id']}'><button>Consulter</button></a></td></tr>";
            }
            ?>
        </tbody>
    </table>
</main>

<?php
require_once '_inc/footer.php';
?>
    