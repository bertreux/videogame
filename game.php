<?php

session_start();

require_once '_inc/functions.php';

[
    'id' => $id,
] = $_GET;

$results = findOneBy($id);

require_once '_inc/header.php';
require_once '_inc/nav.php';

$date = (new DateTime($results['release_date']))->format('d/m/Y');
echo "ID: " . $results["id"] . "<br>";
echo "Titre: " . $results["title"] . "<br>";
echo "Description: " . $results["description"] . "<br>";
// echo "Date de sortie: " . $results["release_date"] . "<br>";
echo "Date de sortie: " . $date. "<br>";
echo "Affiche: <img src='/img/{$results['poster']}' alt='' width='100px' height='100px'>" . "<br>";
echo "Prix: " . $results["price"] . "<br><br>";

?>
<?php
require_once '_inc/footer.php';
?>