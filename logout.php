<?
	setcookie("idutente", "", time()-(60*60*24), "/");
    header('Location: login.php');
?>
