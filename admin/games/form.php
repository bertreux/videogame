<?php

session_start();

require_once '../../_inc/functions.php';

checkAuthentication();

$editor = findAllEditor();
$results = findAllCategory();

processGameForm();

require_once '../../_inc/header.php';
require_once '../_inc/nav.php';

?>

<form method="post" enctype="multipart/form-data">
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
        <input type="file" name="poster" <?= empty(getValues()['id']) ? ' required' : null; ?>>
    </p>
    <p>
        <label>Prix :</label>
        <input type="text" name="price" value="<?= getValues()['price'] ?? null; ?>">
    </p>
    <p>
        <label>Editeur :</label>
        <select name="editor_id">
            <option value=""></option>
            <?php
                $html = '';
                foreach($editor as $key => $value){
                    $html .= "<option value='{$value['id']}'";
                    $html .= isset(getValues()['editor_id']) && getValues()['editor_id'] == $value['id'] ? ' selected' : null;
                    $html .= ">{$value['name']}</option>";
                }
                echo $html;
            ?>
        </select>
    </p>
    <p>
        <?php

            $categoryList = isset(getValues()['category_ids']) ? 
            is_array(getValues()['category_ids']) ? 
            getValues()['category_ids'] : explode(',',getValues()['category_ids']) : [];

            $html = '';
            foreach($results as $key => $value){
                $html .= "<input type='checkbox' name='category_ids[]' value='{$value['id']}'";
                $html .= isset(getValues()['category_ids']) && in_array($value['id'], $categoryList) ? ' checked' : null;
                $html .= ">{$value['name']}";
            }
            echo $html;
        ?>
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