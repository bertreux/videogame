<?php

session_start();

require_once '../_inc/functions.php';

checkAuthentication();

require_once '../_inc/header.php';
require_once '_inc/nav.php';

?>

<a href="/admin/games/">Games index</a>

<?php
require_once '../_inc/footer.php';
?>