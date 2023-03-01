<?php

session_start();

require_once '../../_inc/functions.php';

checkAuthentication();

processGameForm();

require_once '../../_inc/header.php';
require_once '../_inc/nav.php';

?>

<form method="post">
    <p>
        <input type="hidden" name="id" value="<?= getValues()['id'] ?? null; ?>">
    </p>
    <p>
        <label>Titre :</label>
        <input type="text" name="title" value="<?= getValues()['title'] ?? null; ?>">
    </p>
    <p>
        <label>Description :</label>
        <textarea name="description"><?= getValues()['description'] ?? null; ?></textarea>
    </p>
    <p>
        <label>Date de sortie :</label>
        <input type="date" name="release_date" value="<?= getValues()['release_date'] ?? null; ?>">
    </p>
    <p>
        <label>Poster :</label>
        <input type="text" name="poster" value="<?= getValues()['poster'] ?? null; ?>">
    </p>
    <p>
        <label>Prix :</label>
        <input type="text" name="price" value="<?= getValues()['price'] ?? null; ?>">
    </p>
    <p>
        <input type="submit" name="submit">
    </p>
</form>


<?php

if(isset($_POST['submit'])){
    if(getErrors() != null && count(getErrors()) != 0){
        foreach ($errors as $key => $value) {
            echo "<p>$value</p>";
        }
    }
}

require_once '../../_inc/footer.php';
?>