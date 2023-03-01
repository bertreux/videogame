<?php

session_start();

require_once '../../_inc/functions.php';

checkAuthentication();

$results = findAll();

require_once '../../_inc/header.php';
require_once '../_inc/nav.php';

?>

<table>
    <tr>
        <th>Poster</th>
        <th>Titre</th>
        <th>Prix</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
    <?php
        $html = '';

        foreach($results as $key => $value){
            $date = (new DateTime($value['release_date']))->format('d/m/Y');
            $html .= "
                <tr>
                    <td>{$value['poster']}</td>
                    <td>{$value['title']}</td>
                    <td>{$value['price']}</td>
                    <td>$date</td>
                    <td>
                        <a href='#'>Modifier</a>
                        <a href='#'>Supprimer</a>
                    </td>
                </tr>
            ";
        }

        echo $html;
    ?>
</table>

<a href="/admin/games/form.php">Ajouter</a>

<?php
require_once '../../_inc/footer.php';
?>
