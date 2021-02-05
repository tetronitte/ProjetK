<?php 
if(isset($_SESSION)) var_dump($_SESSION);

 ?>

<span>INSCRIPTION</span><br/>
<form action="index.php?action=signup" method="POST">
    <div><label for="nickname">Pseudo :</label><input type="text" name="nickname"/></div>
    <div><label for="password">password :</label><input type="text" name="password"/></div>
    <div><label for="vPassword">vPassword :</label><input type="text" name="vPassword"/></div>
    <input type="submit" value="signin"/>
</form>
<br/><br/>
<span>CONNEXION</span><br/>
<form action="index.php?action=login" method="POST">
    <div><label for="nickname">Pseudo :</label><input type="text" name="nickname"/></div>
    <div><label for="password">password :</label><input type="text" name="password"/></div>
    <input type="checkbox" name="autolog" value="autolog" checked>
    <input type="submit" value="login"/>
</form>
<br/><br/>
<form action="index.php?action=logout" method="POST">
    <input type="submit" value="logout"/>
</form>
<?php

$db = null;

?>