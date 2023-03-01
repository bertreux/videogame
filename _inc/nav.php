<?php
$user = getSessionData('user');
echo $user;
?>
<nav>
    <a href="/"><img src="/img/logo.jpeg" alt="" width="100px" height="100px"></a>
    <a href="/">Accueil</a>
    <a href="/contact.php">Contact</a>
    <a href="/games.php">Games</a>
    <?php if ($user == null){ ?>
    <a href="/login.php">Login</a>
    <?php } else { ?>
    <a href="/logout.php">Logout</a>
    <?php } ?>
</nav>