<?php

function processContactForm()
{
    if(isSubmitted() && isValid()){
        echo 'formulaire soumis et valide';
    }
}

function isSubmitted():bool
{
    return isset($_POST['submit']);
}

function isValid():bool
{
    $constraints = [
        'firstname' => [
            'isValidate' => isIdentity(getValues()['firstname']) && isNotBlank(getValues()['firstname']),
            'message' => 'Prénom incorrect',
        ],
        'lastname' => [
            'isValidate' => isIdentity(getValues()['lastname']) && isNotBlank(getValues()['lastname']),
            'message' => 'Nom incorrect',
        ],
        'email' => [
            'isValidate' => isEmail(getValues()['email']),
            'message' => 'Email incorrect',
        ],
        'subject' => [
            'isValidate' => isNotBlank(getValues()['subject']),
            'message' => 'Subject incorrect',
        ],
        'message' => [
            'isValidate' => isNotBlank(getValues()['message']) && isLong(getValues()['message']),
            'message' => 'Message incorrect',
        ],    
    ];

    $GLOBALS['errors']= [];
    foreach($constraints as $name => $field){
        if(!$field['isValidate']){
            array_push($GLOBALS['errors'], $field['message']); $validation = false;
        }
    }

    return checkConstraints($constraints);
}

function isIdentity(string|null $value):bool
{
    return preg_match("#^[a-zA-Zàáâääåąčćêèéêëè¿ìíîït̃ñòóôõõøùÚÛÜÿÿÿýżźñçčšžÀÁÂÄÄÅĄĆČĖĘÈÉÊËÌÍÎÏ‡ŁÑÒÓÔÖÕØÙÚÛÜчÜŸÝŹŹÑßÇŒÆČŠŽJð
    . ' -]+$#", $value);
}

function isNotBlank(string|null|array $field):bool
{
    return !empty($field);
}

function isEmail($field):bool
{
    if(filter_var($field, FILTER_VALIDATE_EMAIL)){
        return true;
    }else{
        return false;
    }
}

function isLong($field):bool
{
    return strlen($field) >= 10 ? true : false;
}

function checkConstraints(array $constraints):bool
{
    $validation = true;

    foreach($constraints as $name => $field){
        if(!$field['isValidate']){
            $validation = false;
        }
    }
    return $validation;
}

function getValues():array
{
    return $_POST;
}

function getErrors():array|null
{
    return $GLOBALS['errors'] ?? null;
}

function dbConnection(): PDO
{
    $connection = new PDO ('mysql:host=127.0.0.1; dbname=mydb', 'root', 'root', [ PDO :: ATTR_DEFAULT_FETCH_MODE => PDO :: FETCH_ASSOC,]);
    return $connection;
}

?>