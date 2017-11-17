<?
	include 'base.php';
  RedirectSeMancaCookie();
    
  $ok=true;
  $id=$_REQUEST["id"];
  $conn = ConnettiAlDB();
  
  // imposta variabili da salvare
  $luogo=EscapeIfNotEMptyOrNull($conn,$_REQUEST["luogo"]);
  $descrizione=EscapeIfNotEMptyOrNull($conn,$_REQUEST["descrizione"]);
  $descrizione_estesa=EscapeIfNotEMptyOrNull($conn,$_REQUEST["descrizione_estesa"]);
  $targa=EscapeIfNotEMptyOrNull($conn,$_REQUEST["targa"]);
  try {
    $data=$_REQUEST["Data"]. " ".$_REQUEST["Ora"];
		$data = date("Y-m-d H:i:s", strtotime($data));
  } catch (Exception $e) {
    $ok=false;
    $errore="Data/ora errata";
  }

  // controlli comuni
  if(empty($descrizione)) {$ok=false; $errore="Inserire descrizione";};

  if($ok) {
    if(!empty($id)) {
      $stmt = $conn->prepare("UPDATE Accertamento SET data=?, luogo=?, descrizione=?, descrizione_estesa=?, targa=? where idAccertamento=?");
      $stmt->bind_param("sssssi", $data,$luogo,$descrizione,$descrizione_estesa,
      $targa,$id);
      $ok=$stmt->execute();
      $errore=$stmt->error;
    } else  {
        // controlli per insert
        // setup campi default
        $stmt = $conn->prepare("insert into Accertamento (data, luogo, descrizione, descrizione_estesa, targa) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $data,$luogo,$descrizione,$descrizione_estesa,
        $targa);
        $ok=$stmt->execute();
        $errore=$stmt->error;
        if($ok) {
          $id=$conn->insert_id;
        }
    }

  }
  $conn->close();
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
    <? include 'menu.php'; ?>
    <h1>Accertamento</h1>
	<? if($ok) echo "Accertamento salvato id=". $id; else echo "Errore: Accertamento non salvato:" . $errore;?>
	<button type="button" class="btn btn-default" onclick="window.location='index.php'">Home</button>    
	<button type="button" class="btn btn-default" onclick="window.location='accertamento.php?id=<? echo $id;?>'">Torna all'accertamento</button>    
	
	</div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>