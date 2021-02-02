<span>INSCRIPTION</span><br/>
<form action="signin.php" method="post">
    <div><label for="nickname">Pseudo</label><input type="text" name="nickname"/></div>
    <div><label for="password">Mot de passe</label><input type="text" name="password"/></div>
    <div><label for="vPassword">Vérification de mot de passe</label><input type="text" name="vPassword"/></div>
    <button type="submit">signin</button>
</form>

<?php
session_start();
var_dump($_COOKIE);
if(isset($_COOKIE['nickname']) && isset($_COOKIE['pwd'])) {
    echo '<p>Vous êtes connecté grâce aux cookies</p>';
}
else if(isset($_SESSION['nickname']) && isset($_SESSION['id'])) {
    echo '<p>Vous êtes connecté</p>';
}
else {
    echo '<br/>
    <span>CONNEXION</span><br/>
    <form action="login.php" method="post">
        <div><label for="nickname">Pseudo</label><input type="text" name="nickname"/></div>
        <div><label for="password">Mot de passe</label><input type="text" name="password"/></div>
        <div><label for="autolog">Connexion automatique</label><input type="checkbox" id="autolog" name="autolog[]"/></div>
        <button type="submit">login</button>
    </form>';
}
?>
<form action="logout.php" method="post">
    <button type="submit">logout</button>
</form>



