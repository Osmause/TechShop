<?php
/*
 * La fonction prend en compte en paramètre une variable qui est une chaîne de caractères
 * On vérfie si nous avons la clé de notre formulaire
 * alors on créer une variable $value qui prend en compte notre variable $field
 * on vérifie que $value est différent de null
 * on retourne le resultat $value
 * sinon si il est vide il retourne null
 * si il ne respecte pas d'autres critères alors on retourne null 
 * 
 */
function parseField(string $field)
{
    if (isset($_POST[$field])) {
        $value = $_POST[$field];

        if ($value !== null) {
            return cleanInput($value);
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function parseSubmittedForm()
{

    $submittedForm = [
        'firstname' => parseField('firstname'),
        'lastname' => parseField('lastname'),
        'email' => parseField('email'),
        'phone' => parseField('phone'),
        'message' => parseField('message'),
    ];

    $errors = [];


    validateFirstname($submittedForm['firstname'], $errors);
    validateLastname($submittedForm['lastname'], $errors);
    validateEmail($submittedForm['email'], $errors);
    validatePhone($submittedForm['phone'], $errors);
    validateMessage($submittedForm['message'], $errors);


    return [$submittedForm,  $errors];
}


function validateFirstname(mixed $field, array &$errors = []): void
{
    if ($field === null) {
        $errors['firstname'][] = 'Le prénom ne peut pas être null.';
        return;
    }

    if (preg_match('/\d+/', $field)) {
        $errors['firstname'][] = 'Le prénom ne peut pas contenir de chiffre.';
    }

    if (strlen($field) < 2) {
        $errors['firstname'][] = 'Le prénom doit contenir plus que 2 caractères';
    }

    if (strlen($field) > 34) {
        $errors['firstname'][] = 'Le prénom doit pas dépasser 34 caractères';
    }

}

function validateLastname(mixed $field, array &$errors = []): void
{
    if ($field === null) {
        $errors['lastname'][] = 'Le nom ne peut pas être null';
        return;
    }

    if (preg_match('/\d+/', $field)) {
        $errors['lastname'][] = 'Le nom ne peut pas contenir de chiffre';
    }

    if (strlen($field) < 2) {
        $errors['lastname'][] = 'Le nom doit contenir plus que 2 caractères';
    }

    if (strlen($field) > 34) {
        $errors['lastname'][] = 'Le nom doit pas dépasser 34 caractères';
    }




}

function validateEmail(mixed $field, array &$errors = []): void
{

    if (filter_var($field, FILTER_VALIDATE_EMAIL) === false) {

        $errors['email'][] = 'Email invalide';

    }
}

function validatePhone(mixed $field, array &$errors = []): void
{
    if (!preg_match("#^(\+33|0)[67][0-9]{8}$#", $field)) {
        $errors['phone'][] = 'Numéro incorrect, doit être composé de 10 chiffres ou 9 si utilisation de +33';
    }
}

function validateMessage(mixed $field, array &$errors = []): void
{
    if (strlen($field) < 24) {
        $errors['message'][] = 'Le message doit contenir plus que 24 caractères';
    }

    if (strlen($field) > 250) {
        $errors['message'][] = 'Le prénom doit pas dépasser 250 caractères';
    }
}

function cleanInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/pages/contact.css">
    <title>Contact</title>
</head>

<body>



    <?php include('../includes/header.html'); ?>
    <main>
        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $result = parseSubmittedForm();
            
            $formDatas = $result[0];
            $errors = $result[1];
            
        }

    ?>
        <form method="post" id="formhelp">
            <div class="identity">
                <div class="name-container">
                    <label class="text-h2-media" for="firstname">Nom</label>
                    <input type="text" name="firstname" id="firstname" placeholder="Nom de famille" value="<?php echo $formDatas['firstname']?> " required>
                    <?php
                    if (isset($errors['firstname'])) {
                        foreach ($errors['firstname'] as $error) {
                            echo "<p class=\"text-h2-media error\">$error</p>";
                        }
                    }
                    ?>
                </div>
                <div class="name-container">
                    <label class="text-h2-media" for="lastname">Prénom</label>
                    <input type="text" name="lastname" id="lastname" placeholder="Prénom" value="<?php echo $formDatas['lastname']?>" required>
                    <?php
                    if (isset($errors['lastname'])) {
                        foreach ($errors['lastname'] as $error) {
                            echo "<p class=\"text-h2-media error\">$error</p>";
                        }
                    }
                    ?>
                </div>
            </div>
            <label class="text-h2-media" for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Example@techshop.com" value="<?php echo $formDatas['email']?>" required>
            <?php
                if (isset( $errors['email'])){
                    foreach($errors['email'] as $error){
                        echo "<p class=\"text-h2-media error\">$error</p>";
                    }
                }
            ?>
            <label class="text-h2-media" for="phone">Numéro</label>
            <input type="tel" name="phone" id="phone" placeholder="+33 .." value="<?php echo $formDatas['phone']?>" required>
            <?php
                if (isset( $errors['phone'])){
                    foreach($errors['phone'] as $error){
                        echo "<p class=\"text-h2-media error\">$error</p>";
                    }
                }
            ?>
            <label for="message"></label>
            <textarea name="message" id="message" maxlength="250" placeholder="Ecrivez votre problème" required><?php echo $formDatas['message']?></textarea>



            <?php
            if (isset($errors['message'])) {
                foreach ($errors['message'] as $error) {
                    echo "<p class=\"text-h2-media error\">$error</p>";
                }
            }

            ?>
            <button class="submit" type="submit" form="formhelp" value="submit">Envoyer</button>
        </form>
    </main>
    <?php include('../includes/footer.html'); ?>
</body>
<script type="module" src="../assets/js/main.js"></script>

</html>