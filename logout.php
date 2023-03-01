<?php

session_start();

require_once '_inc/functions.php';

unset($_SESSION['user']);

header('Location: http://localhost:8000/');

?>