<?php

require_once '_inc/functions.php';

if(isset($_POST['submit'])){
[
    'firstname' => $firstname,
    'lastname' => $lastname,
    'email' => $email,
    'subject' => $subject,
    'message' => $message,
    'submit' => $submit,
] = $_POST;

$submissionDate = $_SERVER['REQUEST_TIME'];
$dateSubmit = new DateTime;
date_timestamp_set($dateSubmit, $submissionDate);
}

require_once '_inc/header.php';
require_once '_inc/nav.php';

processContactForm();


?>

<form method="post">
    <p>
        <label>First name :</label>
        <input type="text" name="firstname" value="<?= getValues()['firstname'] ?? null; ?>">
    </p>
    <p>
        <label>Last name :</label>
        <input type="text" name="lastname" value="<?= getValues()['lastname'] ?? null; ?>">
    </p>
    <p>
        <label>Email :</label>
        <input type="email" name="email" value="<?= getValues()['email'] ?? null; ?>">
    </p>
    <p>
        <label>Subject :</label>
        <input type="text" name="subject" value="<?= getValues()['subject'] ?? null; ?>">
    </p>
    <p>
        <label>Message :</label>
        <input type="text" name="message" value="<?= getValues()['message'] ?? null; ?>">
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
    }else {
        echo "<p>firstname : $firstname</p>";
        echo "<p>lastnme : $lastname</p>";
        echo "<p>email : $email</p>";
        echo "<p>subject : $subject</p>";
        echo "<p>message : $message</p>";
        echo "<p>submit : ".$dateSubmit->format('Y-m-d H:i:s')."</p>";
    }
}

require_once '_inc/footer.php';

?>