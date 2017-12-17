<?  

	include 'base.php';
  RedirectSeMancaCookie();

  if(!empty($_REQUEST["idAccertamento"])) {
    $file = $_FILES['file'];
    $file_name = $file['name'];
    $file_type = $file ['type'];
    $file_size = $file ['size'];
    $file_path = $file ['tmp_name'];
    $conn = ConnettiAlDB();
    $id=EscapeIfNotEMptyOrNull($conn,$_REQUEST["idAccertamento"]);
    $datadoc = DateTime::createFromFormat("d/m/Y",EscapeIfNotEMptyOrNull($conn,$_REQUEST["data"]))->format("Y-m-d H:i:s");
    $tipo=intval($_REQUEST["tipo"]);
    $descrizione=EscapeIfNotEMptyOrNull($conn,$_REQUEST["descrizione"]);
    if($file_name!="")
      if(move_uploaded_file ($file_path,'tmp/'.$file_name))
      {
        $filename = 'tmp/'.$file_name;
        $handle = fopen($filename, "rb");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        unlink($filename);
        $stmt = $conn->prepare("INSERT INTO Documento (File,idAccertamento,filename,dataDocumento,tipo,descrizione) Values (?,?,?,?,?,?)");
        $stmt->bind_param("bissis", $contents,$id,$file_name,$datadoc,$tipo,$descrizione);
        $ok=$stmt->execute();
        if($ok)
        {
          header('Location: accertamento.php?idAccertamento='.$id);
          return;      
        } 
        
      }

  } 
  else 
  { 
    die("id non trovato");

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
    <h1>Errore</h1>
    <div id="datigenerali">
    </div>

	</div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
