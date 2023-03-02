<?php

session_start();

require_once '_inc/functions.php';

// if(isset($_POST['submit'])){
    processLoginForm();
// }

require_once '_inc/header.php';
require_once '_inc/nav.php';

$message = getSessionFlashMessage('notice');
echo $message;

?>

<form method="post">
    <p>
        <label>Email :</label>
        <input type="email" name="email" value="<?= getValues()['email'] ?? null; ?>">
    </p>
    <p>
        <label>Mot de Passe :</label>
        <input type="password" name="password" value="<?= getValues()['password'] ?? null; ?>">
    </p>
    <p>
        <input type="submit" name="submit">
    </p>
</form>


<?php
require_once '_inc/footer.php';
?>
    