<?
  	include 'base.php';
    RedirectSeMancaCookie();
    $conn = ConnettiAlDB();
    $nome=EscapeIfNotEMptyOrNull($conn,$_REQUEST["nome"]);
    $societa=EscapeIfNotEMptyOrNull($conn,$_REQUEST["societa"]);
    $dn = ($_REQUEST["dataNascita"] != '') ? date("Y-m-d", strtotime($_REQUEST["dataNascita"])) : NULL;
    $ok=true;
    $id=$_REQUEST["idSoggetto"];
    if(empty($nome) && empty($societa)) {$ok=false; $errore="Inserire nome o Societ&agrave;";};
    if($ok) {
      if(!empty($id)) {
        $stmt = $conn->prepare("UPDATE Soggetto SET nome=?, dataNascita=?, luogoNascita=?, residenza=?, tel=?, mail=?, documento=?, indirizzo=?, societa=? where idSoggetto=?");
        $stmt->bind_param("sssssssssi", 
        $nome,
        $dn,
        EscapeIfNotEMptyOrNull($conn,$_REQUEST["luogoNascita"]),
        EscapeIfNotEMptyOrNull($conn,$_REQUEST["residenza"]),
        EscapeIfNotEMptyOrNull($conn,$_REQUEST["tel"]),
        EscapeIfNotEMptyOrNull($conn,$_REQUEST["mail"]),
        EscapeIfNotEMptyOrNull($conn,$_REQUEST["documento"]),
        EscapeIfNotEMptyOrNull($conn,$_REQUEST["indirizzo"]),
        $societa,
        $_REQUEST["idSoggetto"]);
        $ok=$stmt->execute();
        $errore=$stmt->error;
        
      } else {
        $tiposoggetto=0;
        $stmt = $conn->prepare("insert into Soggetto (nome, dataNascita, luogoNascita, residenza, tel, mail, documento, indirizzo, societa, tipo) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssssssi", 
        $nome,
        $dn,
        EscapeIfNotEMptyOrNull($conn,$_REQUEST["luogoNascita"]),
        EscapeIfNotEMptyOrNull($conn,$_REQUEST["residenza"]),
        EscapeIfNotEMptyOrNull($conn,$_REQUEST["tel"]),
        EscapeIfNotEMptyOrNull($conn,$_REQUEST["mail"]),
        EscapeIfNotEMptyOrNull($conn,$_REQUEST["documento"]),
        EscapeIfNotEMptyOrNull($conn,$_REQUEST["indirizzo"]),
        $societa,
        $tiposoggetto);
        $ok=$stmt->execute();
        if($ok) {
          $id=$conn->insert_id;
        }
        else {
          $errore=$stmt->error;
          
        }
          
      }
    
    }
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
    <h1>Soggetto</h1>
	<? if($ok) echo "Soggetto salvato id=". $id; else echo "Errore: Soggetto non salvato: " . $errore; ?>
	<button type="button" class="btn btn-default" onclick="window.location='index.php'">Home</button>    
	<button type="button" class="btn btn-default" onclick="window.location='soggetto.php?idSoggetto=<? echo $id;?>'">Torna al Soggetto</button>    
	
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
<? $conn->close(); ?>