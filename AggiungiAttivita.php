<?
  	include 'base.php';
    RedirectSeMancaCookie();

    $ok=true;
    $idaccertamento=intval($_REQUEST["idAccertamento"]);
    $descrizione=$_REQUEST["descrizione"];
    
    $conn = ConnettiAlDB();
    if(isset($_REQUEST["data"]))
        $datadoc = DateTime::createFromFormat("d/m/Y H:i",EscapeIfNotEMptyOrNull($conn,$_REQUEST["data"]))->format("Y-m-d H:i");
    else
        $datadoc=NULL;
    if($idaccertamento>0) {
      // controlli per update
      $stmt = $conn->prepare("INSERT INTO Attivita (idAccertamento,descrizione,data) VALUES (?,?,?)");
      $stmt->bind_param("iss", $idaccertamento,$descrizione,$datadoc);
      $ok=$stmt->execute();
      $errore=$stmt->error;
      if(!$ok) echo $errore;
      header("Location: accertamento.php?idAccertamento=".$idaccertamento);
    }
    else die("manca id");
    $conn->close();
?>
