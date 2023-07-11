
<?php
require_once('Session.php');
require_once('Validator.php');
require_once('Redirect.php');
require_once('Model.php');
require_once('account.php');
Session::ensureStarted();


if(isset($_POST['submit'])){
    var_dump(Account::changePassword(1, 'password', 'password1', 'password2'));
}

// traite les infos d'authentification. si l'utilisateur est connecté, on le charge dans la session, on l'envoie un cookie et on le redirrige vers la page dacceuil.

?>

<html>
    <head></head>
    <body>
        <form action="" method="POST">
            <input type="password" name="password">
            <input type="password" name="password1">
            <input type="password" name="password2">
            <input type="submit" name="submit" value="connexion">
        </form>
    </body>
</html>