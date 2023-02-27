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
            'isValidate' => true,
            'message' => 'Prénom incorrect',
        ],
        'lastname' => [
            'isValidate' => true,
            'message' => 'Nom incorrect',
        ],
        'email' => [
            'isValidate' => true,
            'message' => 'Email incorrect',
        ],
        'subject' => [
            'isValidate' => true,
            'message' => 'Subject incorrect',
        ],
        'message' => [
            'isValidate' => true,
            'message' => 'Message incorrect',
        ],    
    ];

    return checkConstraints($constraints);
}

function isIdentity(string|null $value):bool
{
    return preg_match("#^[a(zA-Z", $value);
}

function isNotBlank(string|null|array $field):bool
{
    return !empty($field);
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

?>