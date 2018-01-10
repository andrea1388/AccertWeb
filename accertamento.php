<?  
  class Accertamento {
    public $idAccertamento;
    public $numero;
    public $anno;
    public $data;
    public $luogo;
    public $descrizione;
    public $descrizione_estesa;
    public $targa;
  }

	include 'base.php';
  RedirectSeMancaCookie();
 
  /*
  try {
    $id=$_REQUEST["idAccertamento"];
  }
  catch (Exception $e) {};
  */
  if(!empty($_REQUEST["idAccertamento"])) {
    $conn = ConnettiAlDB();
    $id=EscapeIfNotEMptyOrNull($conn,$_REQUEST["idAccertamento"]);
    $stmt = $conn->prepare("SELECT * FROM Accertamento where idAccertamento=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
      die("id non trovato");
    };
    $acc=$result->fetch_object("Accertamento");
    $nuovo=false;
    $readonly=!isset($_REQUEST["edit"]);
  } 
  else 
  {
      $nuovo=true;
      $readonly=false;
      $acc=new Accertamento();
      $d=new DateTime();
      $acc->data=$d->format("Y-m-d G:i:s");
      $acc->anno=$d->format("Y");
      $id=0;
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
      <h1>Accertamento</h1>
      <form class="form-horizontal" method="post" action="salvaAccertamento.php">
        <input type="hidden" name="idAccertamento" value="<? echo $id; ?>">
        <? GeneraFormGroup($acc->numero,"numero","Numero",true); ?>
        <? GeneraFormGroup($acc->anno,"anno","Anno",true); ?>

        <div class="form-group">
            <label for="Data" class="col-sm-2 control-label">Data/Ora</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" id="Data" placeholder="Data" name="Data" value="<? echo FormattaData($acc->data,"d/m/Y"); ?>" <? if($readonly) echo " readonly";?>>
            </div>
            <div class="col-sm-5">
              <input type="text" class="form-control" id="Ora" placeholder="Ora" name="Ora"  value="<? echo FormattaData($acc->data,"G:i:s"); ?>" <? if($readonly) echo " readonly";?>>
            </div>
        </div>

        <? GeneraFormGroup($acc->luogo,"luogo","Luogo",$readonly); ?>
        <? GeneraFormGroup($acc->descrizione,"descrizione","Descrizione",$readonly); ?>


        <div class="form-group">
            <label for="Descrizioneestesa" class="col-sm-2 control-label">Descrizione estesa</label>
            <div class="col-sm-10">
            <textarea rows="4" cols="50" id="Descrizioneestesa" class="form-control"  placeholder="Descrizione estesa" name="descrizione_estesa" <? if($readonly) echo " readonly"; ?>> <? echo trim($acc->descrizione_estesa); ?></textarea>
            </div>
        </div>
        <? GeneraFormGroup($acc->targa,"targa","Targa",$readonly); ?>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Salva</button>
            <? if($readonly) :?>
            <button type="button" class="btn btn-default" onclick="window.location='accertamento.php?edit&idAccertamento=<? echo $id;?>'">Abilita modifiche</button>    
            <?php endif; ?> 
            <? if(!$nuovo) :?>
            <button type="button" class="btn btn-default" onclick="window.location='aggiungidoc.php?idAccertamento=<? echo $id;?>'">Aggiungi documento</button>    
            <?php endif; ?> 
          </div>
        </div>
      </form>


      <? if(!$nuovo) :?>
      <form class="form-horizontal" method="post" action="listaSoggetti.php">
        <div class="form-group alert alert-success">
          <label class="col-sm-2 control-label">Lista soggetti associati</label>
          <div class="col-sm-10">
            <table class="table table-hover table-bordered">
              <tr><td>Soggetto</td><td>Tel</td><td>Ruolo</td><td>Note</td><td>Azioni</td></tr>
              <?
                  // ruolo 1= accertatore 2 =resposnsabile 3 pif 4 altro
                  $stmt = $conn->prepare("SELECT * FROM Soggetto join SoggettoAccertamento on Soggetto.idSoggetto=SoggettoAccertamento.idSoggetto join RuoloSoggetto on SoggettoAccertamento.ruolo=RuoloSoggetto.idRuolo where idAccertamento=?");
                  $stmt->bind_param("i", $_REQUEST["idAccertamento"]);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  while($row = $result->fetch_assoc()) 
                  {
                    echo "<tr><td>".$row['nome']."</td><td>".$row['tel'].
                    "</td><td>" .$row['nomeRuolo']. "</td><td>".$row['descRuolo'].
                    "</td><td><a href='eliminaSoggettoAccertamento.php?idSoggettoAccertamento=".$row['idSoggettoAccertamento']."&idAccertamento=".$id."'>Elimina</a>";
                    echo "&nbsp;<a href='soggetto.php?idSoggetto=".$row['idSoggetto']."'>Apri</a></td></tr>\n";
                  }
              ?>
            </table> 
          </div>
          <input type="hidden" name="idAccertamento" value="<? echo $id; ?>">
          <div class="form-group">
            <label for="descrizione" class="col-sm-2 control-label">Aggiungi soggetto</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="nome" placeholder="Nome" name="dati" value=''>
            </div>
            <div class="col-sm-2">
              <select required name='ruolo'>
                <option value="1">Accertatore</option>
                <option value="2">Responsabile</option>
                <option value="3">Persona informata</option>
                <option value="4">Altro</option>
              </select>
            </div>
            <div class="col-sm-2">
              <input type="text" class="form-control" placeholder="Ruolo" name="descrizioneruolo" value=''>
            </div>
            <div class="col-sm-2">
              <button type="submit" class="btn btn-default">Cerca</button>
            </div>
          </div>
        </div>
      </form>
      <br>
      <form class="form-horizontal" action="AggiungiAttivita.php" method="post">
        <div class="form-group alert alert-info">
          <label class="col-sm-2 control-label">Lista Attivit&agrave;</label>
          <div class="col-sm-10">
            <table class="table table-hover table-bordered">
              <tr><td>Attivit&agrave;</td><td>Data</td><td>Azioni</td></tr>
              <?
                  $stmt = $conn->prepare("SELECT * FROM Attivita where idAccertamento=?");
                  $stmt->bind_param("i", $_REQUEST["idAccertamento"]);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  while($row = $result->fetch_assoc())
                  {
                    if(isset($row['data'])) $dd=date("d/m/Y H:i",strtotime($row['data'])); else $dd="";
                    echo "<tr><td>".$row['descrizione']."</td><td>".$dd.
                    "</td><td><a href='eliminaAttivita.php?idAttivita=".$row['idAttivita']."&idAccertamento=".$id ."'>Elimina</a>".
                    "&nbsp;<a href='modificaAttivita.php?idAttivita=".$row['idAttivita']."&idAccertamento=".$id ."'>Modifica</a></td></tr>";
  
                  }               
              ?>
            </table>          
          </div>
          <input type="hidden" name="idAccertamento" value="<? echo $id; ?>">
          <div class="form-group">
            <label for="descrizione" class="col-sm-2 control-label">Aggiungi attivit&agrave;</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="descrizione" placeholder="Descrizione" name="descrizione" value="" required>
            </div>
            <div class="col-sm-2">
              <input type="date" class="form-control" placeholder="Data" name="data" value="">
            </div>
            <div class="col-sm-2">
              <button type="submit" class="btn btn-default">Aggiungi</button>
            </div>
          </div>
        </div>
      </form>
      <br>
      <form class="form-horizontal" action="upload.php" method="post" enctype="multipart/form-data">
        <div class="form-group alert alert-warning">
          <label class="col-sm-2 control-label">Lista Documenti</label>
          <div class="col-sm-10">
            <table class="table table-hover table-bordered">
              <tr><td>File</td><td>Descrizione</td><td>Azioni</td></tr>
              <?
                  $stmt = $conn->prepare("SELECT * FROM Documento where idAccertamento=?");
                  $stmt->bind_param("i", $_REQUEST["idAccertamento"]);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  while($row = $result->fetch_assoc()) {
                    //echo "<tr><td>".$row['filename']."</td><td>".$row['descrizione']."</td><td>".date("G:i:s",strtotime($row['dataDocumento']))."</td>\n";
                    echo "<tr><td>".$row['filename']."</td><td>".$row['descrizione']."</td>\n";
                    echo "<td><a target='_blank' href='download.php?idDocumento=".$row['idDocumento']."'>Apri</a>&nbsp;";
                    echo "<a href='eliminaDocumentoAccertamento.php?idDocumento=".$row['idDocumento']."&idAccertamento=".$id ."'>Elimina</a></td></tr>";
                  }
                  $conn->close();
              ?>
            </table>          
          </div>
          <input type="hidden" name="idAccertamento" value="<? echo $id; ?>">
          <input type="hidden" name="tipo" value="1">
          <div class="form-group">
            <label for="fileToUpload" class="col-sm-2 control-label">File da aggiungere</label>
            <div class="col-sm-4">
              <input type="file" class="form-control" name="file" id="fileToUpload">
            </div>
            <div class="col-sm-4">
              <input type="input" class="form-control" name="descrizione" placeholder="Descrizione file">
            </div>
            <div class="col-sm-2">
              <button type="submit" class="btn btn-default">Aggiungi</button>
            </div>
          </div>        
        </div>
      </form>
      <?php endif; ?> 
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
