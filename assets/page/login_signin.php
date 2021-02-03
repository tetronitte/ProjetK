<span>INSCRIPTION</span><br/>
<form action="signin.php" method="POST">
    <div><label for="nickname">Pseudo :</label><input type="text" name="nickname"/></div>
    <div><label for="password">password :</label><input type="text" name="password"/></div>
    <div><label for="vPassword">vPassword :</label><input type="text" name="vPassword"/></div>
    <inout type="submit" value="signin"/>
</form>
<br/><br/>
<span>CONNEXION</span><br/>
<form action="login.php" method="POST">
    <div><label for="nickname">Pseudo :</label><input type="text" name="nickname"/></div>
    <div><label for="password">password :</label><input type="text" name="password"/></div>
    <div><label for="autolog">Connexion automatique :</label><input type="checkbox" name="autolog"/></div>
    <input type="submit" value="login"/>
</form>
<br/><br/>
<form action="logout.php" method="POST">
    <input type="submit" value="logout"/>
</form>