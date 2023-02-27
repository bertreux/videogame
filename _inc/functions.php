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
    $connection = new PDO ('mysql:host=127.0.0.1; dbname=videogames', 'root', '', [ PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,]);
    return $connection;
}

function find3Rand()
{
    $connection = dbConnection();
    $sql = 'SELECT * FROM game ORDER BY RAND() LIMIT 3';
    $query = $connection->prepare($sql);
    $query->execute();
    return $query->fetchAll();

    // $results = $query->fetchAll();
    // // Parcourir les lignes de résultats et afficher les valeurs de chaque colonne
    // foreach($results as $row) {
    //     echo "ID: " . $row["id"] . "<br>";
    //     echo "Titre: " . $row["title"] . "<br>";
    //     echo "Description: " . $row["description"] . "<br>";
    //     echo "Date de sortie: " . $row["release_date"] . "<br>";
    //     echo "Affiche: " . $row["poster"] . "<br>";
    //     echo "Prix: " . $row["price"] . "<br><br>";
    // }
}

function findAll()
{
    $connection = dbConnection();
    $sql = 'SELECT * FROM game';
    $query = $connection->prepare($sql);
    $query->execute();
    return $query->fetchAll();

    // $results = $query->fetchAll();
    // // Parcourir les lignes de résultats et afficher les valeurs de chaque colonne
    // foreach($results as $row) {
    //     echo "ID: " . $row["id"] . "<br>";
    //     echo "Titre: " . $row["title"] . "<br>";
    //     echo "Description: " . $row["description"] . "<br>";
    //     echo "Date de sortie: " . $row["release_date"] . "<br>";
    //     echo "Affiche: " . $row["poster"] . "<br>";
    //     echo "Prix: " . $row["price"] . "<br><br>";
    // }
}

function findOneBy(int $id)
{
    $connection = dbConnection();
    $sql = 'SELECT * FROM game WHERE game.id = :id';
    $query = $connection->prepare($sql);
    $query->execute([
        'id' => $id,
    ]);
    return $query->fetch();

    // $results = $query->fetch();
    // // Parcourir la ligne de résultat et afficher la valeur de chaque colonne
    // echo "ID: " . $results["id"] . "<br>";
    // echo "Titre: " . $results["title"] . "<br>";
    // echo "Description: " . $results["description"] . "<br>";
    // echo "Date de sortie: " . $results["release_date"] . "<br>";
    // echo "Affiche: " . $results["poster"] . "<br>";
    // echo "Prix: " . $results["price"] . "<br><br>";
    
}

?>