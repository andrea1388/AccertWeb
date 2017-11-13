<?
	include 'base.php';
    RedirectSeMancaCookie();
	if(isset($_REQUEST["idAccertamento"])) {
  		$conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $stmt = $conn->prepare("UPDATE Accertamento SET data=?, luogo=?, descrizione=?, descrizione_estesa=?, targa=? where idAccertamento=?");
		$data=$_REQUEST["Data"]. " ".$_REQUEST["Ora"];
		$data = date("Y-m-d H:i:s", strtotime($data));
        $stmt->bind_param("sssssi", $data,
		$conn->real_escape_string($_REQUEST["Luogo"]),
		$conn->real_escape_string($_REQUEST["Descrizione"]),
		$_REQUEST["descrizione_estesa"],
		$conn->real_escape_string($_REQUEST["targa"]),
		$_REQUEST["idAccertamento"]);
        $ok=$stmt->execute();
	} else die("manca id");
?>
<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accertamento</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
    <h1>Accertamento</h1>
	<? if($ok) echo "Accertamento salvato"; else echo "Errore: Accertamento non salvato";?>
	<button type="button" class="btn btn-default" onclick="window.location='index.php'">Home</button>    
	<button type="button" class="btn btn-default" onclick="window.location='accertamento.php?idAccertamento=<? echo $_REQUEST["idAccertamento"];?>'">Torna all'accertamento</button>    
	
	</div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>