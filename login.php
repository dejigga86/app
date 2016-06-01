<?php
session_start();
if(isset($_POST['submit1'])) {
 $_SESSION["login"] = "0";
 session_destroy();

} 

if(!isset($_SESSION["login"])){$_SESSION["login"] = "";}
$pdo = new PDO('mysql:host=localhost;dbname=appdatenbank', 'root', '');
 
if(isset($_POST['submit'])) {
	$username = $_POST['username'];
	$passwort = $_POST['passwort'];
	
	$statement = $pdo->prepare("SELECT * FROM backend WHERE username = :username");
	$result = $statement->execute(array('username' => $username));
	$user = $statement->fetch();
		
	//Überprüfung des Passworts
	if ($user !== false && $passwort == $user['passwort']) {
		$_SESSION['UID'] = $user['backID'];
    $_SESSION['rang'] = $user['Rang'];
    $_SESSION["login"]=1;
	} else {
		$errorMessage = "Username oder Passwort war ungültig<br />".$user['passwort'];
	}
	
}
?>
<!DOCTYPE html> 
<html> 
<head>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
<div id="hauptbox"> 
<?php 
if(isset($errorMessage)) {
	echo $errorMessage;
}
echo '<a href="https://www.hs-owl.de/">
<img border="0" alt="HS-OWL" src="hsowl.jpg"> 
</a><h1 align="center" padding=" 0px -10px 0px 0px">Smartphone-App Backend</h1>' ;
?>
<div id="unten_menu">
<?php                                                                 ;
if($_SESSION["login"]==0)
{
echo ' 
<form action="login.php" method="post" class="loggin">
Username:<br>
<input type="text" size="40" maxlength="250" name="username"><br><br>
 
Dein Passwort:<br>
<input type="password" size="40"  maxlength="250" name="passwort"><br>
 
<input type="submit" name="submit" value="Einloggen">      </form>    ';
 
}
else if($_SESSION["login"]==1)
{
echo '<table align="center">';
echo' <tr><td> <a href="ausfall.php">Ausfälle eintragen</a></td>';
echo'<td><a href="raum.php">Raumänderung eintragen</a></td> <form action="" method="post">
<td><input type="submit" name="submit1" value="Ausloggen"></td>     </form></tr></table>';
}


?>

</form> 
</div>
</div>
</body>
</html>