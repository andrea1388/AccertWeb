<?
  $username = "policeapps";
  $password = "";
  $host = "localhost";
  $database = "my_policeapps";

  function RedirectSeMancaCookie() {
    if(!isset($_COOKIE['idutente'])) header('Location: login.php');
  }
?>