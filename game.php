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
$html = "ID: " . $results["id"] . "<br>";
$html .= "Titre: " . $results["title"] . "<br>";
$html .= "Description: " . $results["description"] . "<br>";
$html .= "Date de sortie: " . $date. "<br>";
$html .= "Affiche: <img src='/img/{$results['poster']}' alt='' width='100px' height='100px'>" . "<br>";
$html .= "Prix: " . $results["price"] . "<br><br>";
echo $html;

?>
<?php
require_once '_inc/footer.php';
?>