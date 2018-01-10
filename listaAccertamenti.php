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
    <? include 'menu.php'; ?>
    <h1>Lista accertamenti corrispondenti</h1>
    <table class="table table-bordered table-hover">
    <thead>
    <tr class="warning"><td>Numero</td><td>Anno</td><td>Luogo</td><td>Descrizione</td><td>Soggetti</td></tr>
	</thead>
    <tbody>
    <?
        $conn = ConnettiAlDB();
        $c="%" . EscapeIfNotEMptyOrNull($conn,$_REQUEST['dati']) . "%";
        //$sql = "SELECT * FROM Accertamento WHERE (numero = ? or luogo like ? or descrizione like ? or descrizione_estesa like ?)";

        // select distinct numero,anno,luogo,descrizione, select nome from Soggetto from Accertamento left join SoggettoAccertamento on SoggettoAccertamento.idAccertamento=Accertamento.idAccertamento left join Soggetto on Soggetto.idSoggetto=SoggettoAccertamento.idSoggetto where Accertamento.idAccertamento=2 order by Accertamento.idAccertamento
        $sql="select distinct t2.idAccertamento, numero,anno,luogo,descrizione ,GROUP_CONCAT(distinct t1.nome ) aa from Accertamento t2 left join SoggettoAccertamento t3 on t3.idAccertamento=t2.idAccertamento left join Soggetto t1 on  t1.idSoggetto=t3.idSoggetto  where (t3.ruolo<>1) and (t1.nome like ? or t2.descrizione like ? or t2.luogo like ?) group by t2.idAccertamento order by t2.idAccertamento";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $c,$c,$c);
		$stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr onclick=\"window.document.location='accertamento.php?idAccertamento=".$row["idAccertamento"]."'\";><td>" .
                $row["numero"]. "</td><td>" . $row["anno"]. "</td><td>" . $row["luogo"]. "</td><td>" . $row["descrizione"].
                "</td><td>".$row["aa"]."</td></tr>\n";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
     ?>
    </tbody>
	</table>
    
	</div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
