<?php

require 'src/connec.php';
$pdo = new PDO(DSN, USER, PASS);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$errors = [];

// Clean the $_POST data
$data = cleanData($_POST);


/** VERIFICATION OF THE DATA */

if (empty($data['comment']) OR strlen($data['comment']) > 255) {
    $errors['comment'] = 'Veuillez ajouter un commentaire';
}

/** IF EVERYTHING IS OK -> INSERTION IN MY DATABASE */
if (empty($errors)) {

    $query = "INSERT INTO eval (id, comment) VALUES (NULL, :comment)";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':comment', $data['comment'], PDO::PARAM_STR);

    $statement->execute();

    header('Location: ../public/index.php');
    exit();
}

}?>

<form action="formComment.php" method="post">
    <div class="form-group ">
        <label for="comment">Ajoutez un commentaire de moins de 140 caracteres</label>
        <textarea class="form-control" id="comment" rows="4" name="comment"
                  maxlength="140" required><?= $data['comment'] ?? '' ?></textarea>
        <p><?= $errors['comment'] ?? '' ?></p>
    </div>
</form>