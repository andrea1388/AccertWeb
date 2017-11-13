<?
	include 'base.php';
    RedirectSeMancaCookie();
?>
<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista accertamenti</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
    <h1>Lista accertamenti corrispondenti</h1>
    <table class="table table-bordered table-hover">
    <tr><td>Numero</td><td>Anno</td><td>Luogo</td><td>Descrizione</td></tr>
	 <?
  		$conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $c="%" . $_REQUEST['dati'] . "%";
        $sql = "SELECT * FROM Accertamento WHERE (numero = ? or luogo like ? or descrizione like ? or descrizione_estesa like ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", intval($_REQUEST['dati']),$c,$c,$c);
		$stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr onclick=\"window.document.location='accertamento.php?idAccertamento=".$row["idAccertamento"]."'\";><td>" . $row["numero"]. "</td><td>" . $row["anno"]. "</td><td>" . $row["luogo"]. "</td><td>" . $row["descrizione"] . "</td></tr>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
     ?>
	</table>
    
	</div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
