<?php

function processContactForm():void
{
    if(isSubmitted() && isValid()){
        $_SESSION['notice'] = 'Vous serez contacté dans les plus brefs délais';
        header('Location: http://localhost:8000/');
    }
}

function processLoginForm():void
{
    if(isSubmitted() && isLoginValid()){
        if(checkUser(getValues()['email'],getValues()['password'])){
            echo 'utilisateur authentifié';
            $_SESSION['user'] = getValues()['email'];
            header('Location: http://localhost:8000/admin/');
        } else {
            echo 'utilisateur non authentifié';
        }
    } else if (isSubmitted()) {
        $_SESSION['notice'] = 'Identifiants incorrects';
    }
}

function processGameForm():void
{
    if(isSubmitted() && isNewGameValid()){
        processFileGameForm();
        if(isset($_GET['id'])){
            updateGame(getValues(), getFilesValues());
            $_SESSION['notice'] = 'Jeu vidéo modifié';
        }else {
            insertGame(getValues(), getFilesValues());
            $_SESSION['notice'] = 'Jeu vidéo ajouté';
        }
        header('Location: http://localhost:8000/admin/games/');        
    }

    if(!isSubmitted() && isset($_GET['id'])){
        $GLOBALS['formData'] = findOneBy($_GET['id']);
    }
}

function getUserByLogin(string $login):array|bool
{
    $connection = dbConnection();
    $sql = 'SELECT email, password FROM admin WHERE email = :login';
    $query = $connection->prepare($sql);
    $query->execute([
        'login' => $login,
    ]);
    return $query->fetch() ?? false;
}

function checkUser(string $email, string $password):bool
{
    if(!getUserByLogin($email)){
        return false;
    }

    if(!password_verify($password,getUserByLogin($email)['password'],)){
        return false;
    }

    return true;
}

function isLoginValid():bool
{
    $constraints = [
        'email' => [
            'isValidate' => isEmail(getValues()['email']),
            'message' => 'Email incorrect',
        ],
        'password' => [
            'isValidate' => isLong(getValues()['password'], 8),
            'message' => 'Mot de passe incorrect',
        ],
    ];

    return checkConstraints($constraints);
}

function isNewGameValid():bool
{
    $constraints = [
        'title' => [
            'isValidate' => isNotBlank(getValues()['title']),
            'message' => 'Titre incorrect',
        ],
        'description' => [
            'isValidate' => isNotBlank(getValues()['description']),
            'message' => 'Description incorrect',
        ],
        'release_date' => [
            'isValidate' => isNotBlank(getValues()['release_date']),
            'message' => 'Date de sortie incorrect',
        ],
        'poster' => [
            'isValidate' => getFilesValues()['poster']['error'] === UPLOAD_ERR_OK ? isAllowedMimeType(getFilesValues()['poster']) : isNotBlank(getFilesValues()['poster']),
            'message' => 'Poster incorrect',
        ],
        'price' => [
            'isValidate' => isFloatInRange(getValues()['price'],0,999.99),
            'message' => 'Prix incorrect',
        ],
        'editor_id' => [
            'isValidate' => isNotBlank(getValues()['editor_id']),
            'message' => 'Editeur incorrect',
        ],
        'category_ids' => [
            'isValidate' => isNotBlank(getValues()['category_ids']),
            'message' => 'Category incorrect',
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

function processFileGameForm():void
{
    if(getFilesValues()['poster']['error'] === UPLOAD_ERR_OK){
        generateFileName(getFilesValues()['poster']);
        uploadFile('img', getFilesValues()['poster']);
        if(!empty(getValues()['id'])){
            $data = findOneBy(getValues()['id']);
            removeFile('img', $data['poster']);
        }
    }
}

function uploadFile(string $directory, array $file):void
{
    move_uploaded_file(
        $file['tmp_name'],
        __DIR__ . "/../$directory/{$GLOBALS['fileName']}"
    );
}

function removeFile(string $directory, string $filename):void
{
    unlink(__DIR__ . "/../$directory/$filename");
}

function getExtensionFromFile(array $file):string
{
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    return $finfo->file($file['tmp_name']);
}

function getAllowedMimeTypes():array
{
    return [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
        'image/svg+xml' => 'svg',
    ];
}

function isAllowedMimeType(array $file):bool
{
    return array_key_exists(getExtensionFromFile($file), getAllowedMimeTypes());
}

function generateRandomToken(int $length = 32):string
{
    return bin2hex(random_bytes($length / 2));
}

function generateFileName(array $file):void
{
    $GLOBALS['fileName'] = generateRandomToken() . '.' . getAllowedMimeTypes()[getExtensionFromFile($file)];
}

function isFloatInRange(string $field, float $min, float $max):bool
 {
    if(filter_var($field, FILTER_VALIDATE_FLOAT)){
        if($field >= $min && $field <= $max){
            return true;
        }
    }

    return false;
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
            'isValidate' => isNotBlank(getValues()['message']) && isLong(getValues()['message'],10),
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

function isEmail(string $field):bool
{
    if(filter_var($field, FILTER_VALIDATE_EMAIL)){
        return true;
    }else{
        return false;
    }
}

function isLong(string $field, int $lenght):bool
{
    return strlen($field) >= $lenght ? true : false;
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
    if(isset($GLOBALS['formData'])){
        return $GLOBALS['formData'];
    }else {
        return $_POST;
    }  
}

function getFilesValues():array
{
    return $_FILES;
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
}

function findAll()
{
    $connection = dbConnection();
    $sql = 'SELECT * FROM game';
    $query = $connection->prepare($sql);
    $query->execute();
    return $query->fetchAll();
}

function findAllEditor()
{
    $connection = dbConnection();
    $sql = 'SELECT * FROM editor';
    $query = $connection->prepare($sql);
    $query->execute();
    return $query->fetchAll();
}

function findAllCategory()
{
    $connection = dbConnection();
    $sql = 'SELECT * FROM category';
    $query = $connection->prepare($sql);
    $query->execute();
    return $query->fetchAll();
}

function findOneBy(int $id)
{
    $connection = dbConnection();

    $sql = 'select  game.*, group_concat(game_category.category_id) as category_ids
    from game
    join category
    join game_category
    on game_category.game_id =  game.id
    and game_category.category_id =  category.id
    where game.id = :id
    group by game.id';

    $query = $connection->prepare($sql);
    $query->execute([
        'id' => $id,
    ]);
    return $query->fetch();    
}

function getSessionFlashMessage(string $sessionKey)
{
    if(array_key_exists($sessionKey, $_SESSION)){
        $notice = $_SESSION[$sessionKey];
        unset($_SESSION[$sessionKey]);
        return $notice;
    }else {
        return null;
    }
}

function getSessionData(string $sessionKey)
{
    if(array_key_exists($sessionKey, $_SESSION)){
        return $_SESSION[$sessionKey];
    }else {
        return null;
    }
}

function checkAuthentication()
{
    if(array_key_exists('user', $_SESSION)){

    } else {
        $_SESSION['notice'] = 'Accès refusé';
        header('Location: http://localhost:8000/');
    }
}

function insertGame(array $game, array $fileValues)
{
    $connection = dbConnection();

    $sql = '
        start transaction;
        insert into game ( title, description, release_date, poster, price, editor_id ) VALUES ( :title, :description, :release_date, :poster, :price, :editor_id );
        set @id = last_insert_id();
        insert into game_category values'
    ;
                    
    foreach($game['category_ids'] as $key => $value){
        $sql .= "(@id, $value)";
        if($value !== end($game['category_ids'])){
            $sql .= ',';
        }
    }

    $sql .= '
        ;
        commit;
    ';


    $query = $connection->prepare($sql);
    $query->execute([
        'title' => $game['title'],
        'description' => $game['description'],
        'release_date' => $game['release_date'],
        'poster' => $GLOBALS['fileName'],
        'price' => $game['price'],
        'editor_id' => $game['editor_id'],
    ]);
}

function updateGame(array $game, array $fileValues)
{
    $data = findOneBy($game['id']);

    $connection = dbConnection();

    $sql = '
    start transaction;
    UPDATE game SET title = :title, description = :description, release_date = :release_date, poster = :poster, price = :price, editor_id = :editor_id WHERE id = :id;
    delete from game_category where game_category.game_id = :id;
    insert into game_category values'
    ;

    foreach($game['category_ids'] as $key => $value){
        $sql .= "(:id, $value)";
        if($value !== end($game['category_ids'])){
            $sql .= ',';
        }
    }

    $sql .= '
        ;
        commit;
    ';

    $query = $connection->prepare($sql);
    $query->execute([
        'id' => $game['id'],
        'title' => $game['title'],
        'description' => $game['description'],
        'release_date' => $game['release_date'],
        'poster' => $fileValues['poster']['error'] === UPLOAD_ERR_NO_FILE ? $data['poster'] : $GLOBALS['fileName'],
        'price' => $game['price'],
        'editor_id' => $game['editor_id'],
    ]);
}

function deleteGame()
{
    $id = $_GET['id'];

    $data = findOneBy($id);
    removeFile('img', $data['poster']);

    $connection = dbConnection();

    $sql = '
        start transaction;
        delete from game_category where game_category.game_id = :id;
        delete from game WHERE game.id = :id;
        commit;
    ';

    $query = $connection->prepare($sql);
    $query->execute([
        'id' => $id
    ]);

    $_SESSION['notice'] = 'Jeu vidéo supprimé';
    header('Location: http://localhost:8000/admin/games/');       
}

?>