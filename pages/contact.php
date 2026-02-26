<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/pages/contact.css">
    <title>Contact</title>
</head>

<body>
    <?php ?>


    <?php include('../includes/header.html'); ?>
    <main>
        <form action="action_page_contact.php" method="post" id="formhelp">
            <div class="identity">
                <div class="name-container">
                    <label class="text-h2-media" for="fname">Nom</label>
                    <input type="text" name="fname" placeholder="Nom de famille">
                </div>
                <div class="name-container">
                    <label class="text-h2-media" for="lname">Prénom</label>
                    <input type="text" name="lname" id="last" placeholder="Prénom">
                </div>
            </div>
            <label class="text-h2-media" for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Example@techshop.com">
            <label class="text-h2-media" for="phone">Numéro</label>
            <input type="tel" name="phone" id="pnumber" placeholder="+33 ..">
            <label for="message"></label>
            <textarea name="message" id="message" minlength="50" maxlength="1045" placeholder="Ecrivez votre problème" required></textarea>
            <button class="submit" type="submit" form="formhelp" value="submit">Envoyer</button>
        </form>
    </main>
    <?php include('../includes/footer.html'); ?>
</body>
<script type="module" src="../assets/js/main.js"></script>
</html>