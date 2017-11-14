<?
	include 'base.php';
    RedirectSeMancaCookie();
?>
<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista soggetti</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
    <? include 'menu.php'; ?>
    <h1>Lista soggetti corrispondenti</h1>
    
    <table class="table table-bordered table-hover">
    <tr><td>Nome</td><td>Indirizzo</td><td>Telefono</td></tr>
	 <?
        $conn = ConnettiAlDB();        
        $c="%" . $_REQUEST['dati'] . "%";
        $sql = "SELECT * FROM Soggetto WHERE (nome like ? or societa like ? or residenza like ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $c,$c,$c);
		$stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr onclick=\"window.document.location='soggetto.php?idSoggetto=".$row["idSoggetto"]."'\";><td>" . $row["nome"]. "</td><td>" . $row["residenza"]. " - " . $row["indirizzo"]. "</td><td>" . $row["telefono"] . "</td></tr>";
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
