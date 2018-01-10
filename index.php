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
      <h1>Accert - versione web</h1>
      <br>
      <button type="button" class="btn btn-primary" onclick="window.location='soggetto.php'">Nuovo soggetto</button>    
      &nbsp;
      <button type="button" class="btn btn-primary" onclick="window.location='accertamento.php'">Nuovo accertamento</button>    
      &nbsp;
      <button type="button" class="btn btn-primary" onclick="window.location='cercaAccertamento.php'">Cerca Accertamento</button>    
      &nbsp;
      <button type="button" class="btn btn-primary" onclick="window.location='logout.php'">Esci</button>    
      <br><br>
      <h2>Lista Attivit&agrave; da completare</h2>
      <table class="table table-hover table-bordered">
        <thead>
        <tr class="info"><td>Attivit&agrave;</td><td>Accertamento</td><td>Soggetti</td></tr>
        </thead>
        <tbody>
        <?
            $conn = ConnettiAlDB();
            $stmt = $conn->prepare("select t4.descrizione datt, t2.idAccertamento ida, luogo, t2.descrizione dacc ,GROUP_CONCAT(distinct t1.nome ) sogg from Accertamento t2 left join SoggettoAccertamento t3 on t3.idAccertamento=t2.idAccertamento left join Soggetto t1 on  t1.idSoggetto=t3.idSoggetto join Attivita t4 on t4.idAccertamento=t2.idAccertamento where (t3.ruolo<>1) and t4.data is null group by t4.idAttivita order by t2.data desc");
            $stmt->execute();
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc())
            {
              echo "<tr onclick=\"window.document.location='accertamento.php?idAccertamento=".$row["ida"]."'\";><td>".$row['datt']."</td><td>".$row['dacc']."</td><td>".$row['sogg']."</td></tr>\n";
            }               
        ?>
        </tbody>
      </table>          
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
