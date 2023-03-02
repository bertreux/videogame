<?php

session_start();

require_once '_inc/functions.php';

$results = findAll();

require_once '_inc/header.php';
require_once '_inc/nav.php';

?>
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
            $html = '';
            foreach($results as $row) {
                $html .= "<tr><td>" . $row["title"] . "</td>";
                $html .= "<td><img src='/img/{$row['poster']}' alt='' width='100px' height='100px'>" . "</td>";
                $html .= "<td>" . $row["price"] . "</td>";
                $html .= "<td><a href='/game.php?id={$row['id']}'><button>Consulter</button></a></td></tr>";
            }
            echo $html;
            ?>
        </tbody>
    </table>

<?php
require_once '_inc/footer.php';
?>